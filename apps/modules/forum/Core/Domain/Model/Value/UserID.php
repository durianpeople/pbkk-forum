<?php

namespace Module\Forum\Core\Domain\Model\Value;

class UserID
{
    protected string $guid;

    public static function generate(): UserId
    {
        $len = 16;
        $secure = true;
        return new UserID(bin2hex(openssl_random_pseudo_bytes($len, $secure)));
    }

    public function __construct(string $guid)
    {
        $this->guid = $guid;
    }

    public function getIdentifier(): string
    {
        return $this->guid;
    }
}