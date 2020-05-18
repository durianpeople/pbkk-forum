<?php

namespace Module\Post\Infrastructure\Persistence\Repository;

use Module\Post\Core\Domain\Interfaces\ICommentRepository;
use Module\Post\Core\Domain\Model\Entity\Post;
use Module\Post\Core\Domain\Model\Entity\Comment;
use Module\Post\Core\Domain\Model\Entity\User;
use Module\Post\Core\Domain\Model\Value\PostID;
use Module\Post\Core\Domain\Model\Value\CommentID;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Infrastructure\Persistence\Record\PostRecord;
use Module\Post\Infrastructure\Persistence\Record\UserRecord;
use Module\Post\Infrastructure\Persistence\Record\CommentRecord;
use Module\Post\Infrastructure\Persistence\Record\CommentVotesRecord;

use Module\Post\Core\Exception\NotFoundException;

use Phalcon\Mvc\Model\Transaction\Manager;
use ReflectionClass;

class CommentRepository implements ICommentRepository
{
    private function reconstituteFromRecord(CommentRecord $comment_record): Comment
    {
        $comment = new Comment(new CommentID($comment_record->id), $comment_record->content, new UserID($comment_record->author_id), new PostID($comment_record->post_id), $comment_record->created_date);
        $votes = [];
        foreach ($comment_record->voted_members as $cr) {
            $votes[] = new UserID($cr->id);
        }
        $comment->voted_members = $votes;
        return $comment;
    }

    public function all(): array
    {
        $comments = [];
        $comment_records = CommentRecord::find();
        foreach ($comment_records as $comment_record) {
            $comments[] = $this->reconstituteFromRecord($comment_record);
        }
        return $comments;
    }

    public function findByID(CommentID $comment_id): Comment
    {
        $comment_record = CommentRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $comment_id->getID()
            ]
        ]);
        if (!$comment_record) throw new NotFoundException("Comment not Found");
        return $this->reconstituteFromRecord($comment_record);
    }

    public function findByPostID(PostID $post_id): array
    {
        $comments = [];
        $comment_records = CommentRecord::find([
            'conditions' => 'post_id = :post_id:',
            'bind' => [
                'post_id' => $post_id->getID()
            ]
        ]);
        if (!$comment_records) throw new NotFoundException("Comment not Found");
        foreach ($comment_records as $comment_record) {
            $comments[] = $this->reconstituteFromRecord($comment_record);
        }
        return $comments;
    }

    public function isAuthorizedComment(CommentID $comment_id, UserID $user_id): bool
    {
        $comment_record = CommentRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $comment_id->getID()
            ]
        ]);
        if (!$comment_record) throw new NotFoundException("Comment not Found");
        $user_record = UserRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $user_id->getID()
            ]
        ]);
        if (!$user_record) throw new NotFoundException("User not Found");
        $post_id = $comment_record->post_id;
        $post_record = PostRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $post_id
            ]
        ]);
        if (!$post_record) throw new NotFoundException("Post not Found");
        return ($post_record->author_id == $user_record->id) || ($comment_record->author_id == $user_record->id);
    }
    //public function findAuthoredPost(UserID $author_id): Post
    //{
    //$user_record = UserRecord::findFirst([
    //'conditions' => 'username = :username:',
    //'bind' => [
    //'username' => $username
    //]
    //]);
    //if (!$user_record) throw new NotFoundException;

    //$user = $this->reconstituteFromRecord($user_record);
    //if (!$user->password->verify($password)) throw new WrongLoginException;
    //return $user;
    //}

    public function persist(Comment $comment): bool
    {
        if ($comment->will_be_deleted) {
            return $this->delete($comment);
        }
        $comment_record = new CommentRecord();
        $comment_record->id = $comment->id->getID();
        $comment_record->content = $comment->content;
        $comment_record->author_id = $comment->author_id->getID();
        $comment_record->post_id = $comment->post_id->getID();
        $comment_record->created_date = $comment->created_date;

        $trx = (new Manager())->get();

        try {
            foreach ($comment->voted_members as $vm) {
                $vr = new CommentVotesRecord();
                $vr->voter_id = $vm->getID();
                $vr->voted_comment_id = $comment->id->getID();
                $vr->save();
            }
            $comment_record->save();
            $trx->commit();
            return true;
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }
        return false;
    }

    public function delete(Comment $comment): bool
    {
        $comment_record = new CommentRecord();
        $comment_record->id = $comment->id->getID();
        $comment_record->title = $comment->title;
        $comment_record->author_id = $comment->author_id->getID();
        $comment_record->content = $comment->content;
        $comment_record->created_date = $comment->created_date;

        $trx = (new Manager())->get();

        try {
            $voted_members = CommentVotesRecord::find([
                'conditions' => 'voted_comment_id = :voted_comment_id:',
                'bind' => [
                    'voted_comment_id' => $comment->id->getID()
                ]
            ]);
            $voted_members->delete();
            $comment_record->delete();
            $trx->commit();
            return true;
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }

        return false;
    }
}
