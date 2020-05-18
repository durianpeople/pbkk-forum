<?php

namespace Module\Forum\Core\Domain\Model\Value;

class PostID
{
    protected string $guid;

    public static function generate(): PostID
    {
        $len = 16;
        $secure = true;
        return new PostID(bin2hex(openssl_random_pseudo_bytes($len, $secure)));
    }

    public function __construct(string $guid)
    {
        if (strlen($guid) < 32) throw new \AssertionError("ID should be GUID with 32 character length");
        $this->guid = $guid;
    }

    public function getIdentifier(): string
    {
        return $this->guid;
    }
}