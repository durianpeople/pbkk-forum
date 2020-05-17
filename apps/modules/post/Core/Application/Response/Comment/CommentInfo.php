<?php

namespace Module\Post\Core\Application\Response\Comment;

class CommentInfo {
  public string $comment_id;
  public string $comment_content;
  public string $comment_author_name;
  public string $comment_author_id;
  public string $comment_created_date;
  public int $comment_votes;
}
