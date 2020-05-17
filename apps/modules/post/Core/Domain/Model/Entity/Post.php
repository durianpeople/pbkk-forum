<?php

namespace Module\Post\Core\Domain\Model\Entity;

use Module\Post\Core\Domain\Model\Value\PostID;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Core\Exception\DuplicateVoteException;

class Post {
  protected PostID $id;
  protected string $title;
  protected string $content;
  protected UserID $author_id;
  protected string $created_date;
  protected array $voted_members = [];
  protected array $comments = [];
  protected bool $will_be_deleted;
  
  public static function create(string $title, string $content, UserID $author): Post {
    return new self(PostID::generate(), $title, $content, $author, date('F j, Y, g:i a', time()));
  }

  public function __construct(PostID $id, string $title, string $content, UserID $author, string $date) {
    $this->id = $id;
    $this->title = $title;
    $this->content = $content;
    $this->author_id = $author;
    $this->created_date = $date;
    $this->will_be_deleted = false;
  }

  public function __get($val) {
    return $this->{$val};
  }

  public function __set($key, $val) {
    $this->{$key} = $val;
  }

  public function addVote(UserID $user_id) : bool {
    if (in_array($user_id, $this->voted_members)) {
      throw new DuplicateVoteException;
      return false;
    }

    $this->voted_members[] = $user_id;
    return true;
  }
}
