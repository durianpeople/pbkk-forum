<?php

namespace Module\Post\Core\Application\Request\Comment;

class CommentCreateRequest {
  public string $comment_content;
  public string $comment_author_id;
  public string $comment_post_id;
}
