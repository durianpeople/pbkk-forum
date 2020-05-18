<?php

namespace Module\Integration\Core\Domain\Model;

use Module\Integration\Core\Exception\PasswordAssertionError;

class Password
{
    protected $password_hash;

    public static function createFromString(string $password)
    {
        assert(strlen($password) >= 8, new PasswordAssertionError);

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

    public function testAgainst(string $input_password): bool
    {
        return password_verify($input_password, $this->password_hash);
    }
}
