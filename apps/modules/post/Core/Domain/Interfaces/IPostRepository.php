<?php

namespace Module\Post\Core\Domain\Interfaces;

use Module\Post\Core\Domain\Model\Entity\User;
use Module\Post\Core\Domain\Model\Entity\Post;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Core\Domain\Model\Value\PostID;

interface IPostRepository {
    public function all(): array;
    public function findByID(PostID $id): Post;
    public function persist(Post $post): bool;
    public function delete(Post $post): bool;
}
