<?php

namespace Module\Forum\Core\Domain\Model\Value;

class Password
{
    protected $password_hash;

    public static function createFromString(string $password) {
        return new self(password_hash($password, PASSWORD_DEFAULT));
    }

    public function __construct(string $password_hash)
    {
        $this->password_hash = $password_hash;
    }

    public function getHash(): string
    {
        return $this->password_hash;
    }
}