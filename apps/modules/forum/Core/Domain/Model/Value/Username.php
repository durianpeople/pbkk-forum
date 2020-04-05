<?php

namespace Module\Forum\Core\Domain\Model\Value;

class Username implements IIdentity
{
    protected $username;

    public function __construct(string $username)
    {
        // Check username validity
        $this->username = $username;
    }

    public function getIdentifier()
    {
        return $this->username;
    }
}