<?php

namespace Module\Post\Core\Application\Request\Post;

class PostVoteRequest {
  public string $post_id;
  public string $voter_id;
}

