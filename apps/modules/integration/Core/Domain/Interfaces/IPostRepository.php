<?php

namespace Module\Integration\Core\Domain\Interfaces;

use Module\Integration\Core\Domain\Model\ForumID;
use Module\Integration\Core\Domain\Model\Post;
use Module\Integration\Core\Domain\Model\PostID;

interface IPostRepository
{
    public function find(PostID $id): Post;
    /**
     * Find posts by forum id
     *
     * @param ForumID $forum_id
     * @return Post[]
     */
    public function findPostsByForum(ForumID $forum_id): array;
    public function getForumNameByForumID(ForumID $forum_id): string;
    public function persist(Post $post): bool;
}
