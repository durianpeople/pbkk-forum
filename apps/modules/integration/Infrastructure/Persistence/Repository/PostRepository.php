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
use Module\Integration\Infrastructure\Persistence\Record\PostForumRecord;
use Module\Integration\Infrastructure\Persistence\Record\PostRecord;
use Phalcon\Mvc\Model\Transaction\Manager;

class PostRepository implements IPostRepository
{
    private function reconstituteFromRecord(PostRecord $post_record): Post
    {
        $post = new Post(
            new ForumID($post_record->post_forum->forum_id),
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
        /** @var PostForumRecord[] */
        $post_forum_records = PostForumRecord::find([
            'conditions' => 'forum_id = :id:',
            'bind' => [
                'id' => $forum_id->getIdentifier()
            ]
        ]);

        $posts = [];
        foreach ($post_forum_records as $pfr) {
            $posts[] = $this->reconstituteFromRecord($pfr->post);
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
        $post_forum_record = new PostForumRecord();
        $post_forum_record->forum_id = $post->forum_id->getIdentifier();
        $post_forum_record->post_id = $post->id->getID();
        $post_forum_record->save();
        return true;
    }
}
