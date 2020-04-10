<?php

namespace Module\Forum\Core\Domain\Model\Value;

class ForumID
{
    protected string $guid;

    public static function generate(): ForumID
    {
        $len = 16;
        $secure = true;
        return new ForumID(bin2hex(openssl_random_pseudo_bytes($len, $secure)));
    }

    public function __construct(string $guid)
    {
        $this->guid = $guid;
    }

    public function getIdentifier()
    {
        return $this->guid;
    }
}
