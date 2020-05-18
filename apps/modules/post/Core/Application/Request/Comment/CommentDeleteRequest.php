<?php

namespace Module\Post\Core\Application\Request\Comment;

class CommentDeleteRequest
{
    public string $comment_id;
    public string $comment_author_id;
}
