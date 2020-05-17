<?php

namespace Module\Post\Core\Domain\Interfaces;

use Module\Post\Core\Domain\Model\Entity\User;
use Module\Post\Core\Domain\Model\Entity\Post;
use Module\Post\Core\Domain\Model\Entity\Comment;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Core\Domain\Model\Value\CommentID;
use Module\Post\Core\Domain\Model\Value\PostID;

interface ICommentRepository {
    public function all(): array;
    public function findByID(CommentID $comment_id): Comment;
    public function findByPostID(PostID $post_id): array;
    public function persist(Comment $comment): bool;
    public function delete(Comment $comment): bool;
}
