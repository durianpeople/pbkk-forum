<?php

namespace Module\Forum\Core\Domain\Model\Value;

class Credential
{
    protected $hashed_credential;

    public static function createFromPassword(string $password) {
        return new self(password_hash($password, PASSWORD_DEFAULT));
    }

    public function __construct(string $hashed_credential)
    {
        $this->hashed_credential = $hashed_credential;
    }
}