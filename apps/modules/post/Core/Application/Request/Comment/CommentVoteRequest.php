<?php

namespace Module\Post\Core\Application\Request\Comment;

class CommentVoteRequest {
  public string $comment_id;
  public string $voter_id;
}

