<?php

namespace Module\Post\Core\Domain\Repository;

use Module\Post\Core\Domain\Interfaces\IPostRepository;
use Module\Post\Core\Domain\Interfaces\ICommentRepository;
use Module\Post\Core\Domain\Model\Entity\Post;
use Module\Post\Core\Domain\Model\Entity\User;
use Module\Post\Core\Domain\Model\Value\PostID;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Core\Domain\Model\Value\CommentID;
use Module\Post\Core\Domain\Record\PostRecord;
use Module\Post\Core\Domain\Record\UserRecord;
use Module\Post\Core\Domain\Record\PostVotesRecord;
use Module\Post\Core\Domain\Record\CommentRecord;

use Phalcon\Mvc\Model\Transaction\Manager;
use ReflectionClass;

class PostRepository implements IPostRepository
{
    private function reconstituteFromRecord(PostRecord $post_record): Post
    {
        $comment_repo = new CommentRepository();
        $post = new Post(new PostID($post_record->id), $post_record->title, $post_record->content, new UserID($post_record->author_id), $post_record->created_date);
        $votes = [];
        foreach ($post_record->voted_members as $pr) {
          $votes[] = new UserID($pr->id);          
        }
        $comments = [];
        foreach($post_record->comments as $pc) {
          $comments[] = $comment_repo->findByID(new CommentID($pc->id));
        }
        $post->voted_members = $votes;
        $post->comments = $comments;
        return $post;
    }

    public function all(): array {
      $posts = [];
      $post_records = PostRecord::find();
      foreach ($post_records as $post_record) {
        $posts[] = $this->reconstituteFromRecord($post_record);
      }
      return $posts;
    }

    public function findByID(PostID $post_id): Post
    {
        $post_record = PostRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $post_id->getID()
            ]
        ]);
        if (!$post_record) throw new NotFoundException;
        return $this->reconstituteFromRecord($post_record);
    }

    public function isAuthorizedPost(PostID $post_id, UserID $user_id): bool {
        $post_record = PostRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $post_id->getID()
            ]
        ]);
        if (!$post_record) throw new NotFoundException;
        $user_record = UserRecord::findFirst([
          'conditions' => 'id = :id:',
          'bind' => [
            'id' => $user_id->getID()
          ]
        ]);
        if (!$user_record) throw new NotFoundException;
        return $post_record->author_id == $user_record->id;
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

    public function persist(Post $post): bool
    {
        if ($post->will_be_deleted) {
          return $this->delete($post);
        }
        $post_record = new PostRecord();
        $post_record->id = $post->id->getID();
        $post_record->title = $post->title;
        $post_record->content = $post->content;
        $post_record->author_id = $post->author_id->getID();
        $post_record->created_date = $post->created_date;

        $trx = (new Manager())->get();

        try {
            foreach($post->voted_members as $vm) {
              $vr = new PostVotesRecord();
              $vr->voter_id = $vm->getID();
              $vr->voted_post_id = $post->id->getID();
              $vr->save();
            }
            $post_record->save();
            $trx->commit();
            return true;
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }
        return false;
    }

    public function delete(Post $post): bool
    {
        $post_record = new PostRecord();
        $post_record->id = $post->id->getID();
        $post_record->title = $post->title;
        $post_record->author_id = $post->author_id->getID();
        $post_record->content = $post->content;
        $post_record->created_date = $post->created_date; 

        $trx = (new Manager())->get();
        
        try {
          $voted_members = PostVotesRecord::find([
            'conditions' => 'voted_post_id = :voted_post_id:',
            'bind' => [
              'voted_post_id' => $post->id->getID()
            ]
          ]);
          $voted_members->delete();
          $comment_repo = new CommentRepository();
          foreach ($post->comments as $comment) {
            $comment_repo->delete($comment);
          }
            
            $post_record->delete();
            $trx->commit();
            return true;
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }

        return false;
    }
}
