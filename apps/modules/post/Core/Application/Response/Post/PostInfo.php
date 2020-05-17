<?php

namespace Module\Post\Core\Application\Response\Post;

use Module\Post\Core\Application\Response\Comment\CommentInfo;

class PostInfo {
  public string $post_id;
  public string $post_title;
  public string $post_content;
  public string $post_author_name;
  public string $post_author_id;
  public string $post_created_date;
  public int $post_votes;
  public array $post_comments;
}
