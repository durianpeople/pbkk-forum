<?php

namespace Module\Forum\Core\Domain\Model\Value;

class UserID
{
    protected int $id;

    public function __construct(int $id)
    {
        // Check username validity
        $this->id = $id;
    }

    public function getIdentifier()
    {
        return $this->id;
    }
}