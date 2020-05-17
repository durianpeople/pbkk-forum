<?php

namespace Module\Post\Core\Domain\Model\Entity;

use Module\Post\Core\Domain\Model\Value\Password;
use Module\Post\Core\Domain\Model\Value\UserID;

class User {
  protected UserID $id;
  protected string $username;
  protected Password $password;
  
  public static function create(string $username, string $password): User {
    return new User(UserID::generate(), $username, Password::generate($password));
  }

  public function __construct(UserID $id, string $username, Password $password) {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
  }

  public function __get($val) {
    return $this->{$val};
  }
}
