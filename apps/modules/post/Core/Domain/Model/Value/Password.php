<?php

namespace Module\Post\Core\Domain\Model\Value;

class Password {
  protected string $password_hash;

  public static function generate(string $password): Password {
    return new self(password_hash($password, PASSWORD_DEFAULT));
  }

  public function __construct(string $hash) {
    $this->password_hash = $hash;
  }

  public function getHash(): string {
    return $this->password_hash;
  }

  public function verify(string $password): bool {
    return password_verify($password, $this->password_hash);
  }
}
