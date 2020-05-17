<?php

namespace Module\Post\Core\Application\Request\Post;

class PostCreateRequest {
  public string $post_author_id;
  public string $post_title;
  public string $post_content;
}

