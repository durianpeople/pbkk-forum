<?php

namespace Module\Integration\Infrastructure\Persistence\Repository;

use DateTime;
use Module\Integration\Core\Domain\Interfaces\IPostRepository;
use Module\Integration\Core\Domain\Model\ForumID;
use Module\Integration\Core\Domain\Model\Post;
use Module\Integration\Core\Domain\Model\PostID;
use Module\Integration\Core\Domain\Model\UserID;
use Module\Integration\Core\Exception\NotFoundException;
use Module\Integration\Infrastructure\Persistence\Record\ForumRecord;
use Module\Integration\Infrastructure\Persistence\Record\PostRecord;
use Phalcon\Mvc\Model\Transaction\Manager;

class PostRepository implements IPostRepository
{
    private function reconstituteFromRecord(PostRecord $post_record): Post
    {
        $post = new Post(
            new ForumID($post_record->forum_id),
            new PostID($post_record->id),
            $post_record->title,
            $post_record->content,
            new UserID($post_record->author_id),
            new DateTime($post_record->created_date),
            $post_record->countVotes()
        );
        return $post;
    }

    public function find(PostID $post_id): Post
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

    public function findPostsByForum(ForumID $forum_id): array
    {
        $post_records = PostRecord::find([
            'conditions' => 'forum_id = :id:',
            'bind' => [
                'id' => $forum_id->getIdentifier()
            ]
        ]);

        $posts = [];
        foreach ($post_records as $pr) {
            $posts[] = $this->reconstituteFromRecord($pr);
        }

        return $posts;
    }

    public function getForumNameByForumID(ForumID $forum_id): string
    {
        /** @var ForumRecord */
        $fr = ForumRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $forum_id->getIdentifier()
            ]
        ]);

        return $fr->name;
    }

    public function persist(Post $post): bool
    {
        $post_record = new PostRecord();
        $post_record->id = $post->id->getID();
        $post_record->title = $post->title;
        $post_record->content = $post->content;
        $post_record->author_id = $post->author_id->getIdentifier();
        $post_record->created_date = $post->created_date->format('F j, Y, g:i a');
        $post_record->forum_id = $post->forum_id->getIdentifier();
        $post_record->save();
        return true;
    }
}
