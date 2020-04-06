<?php

namespace Module\Forum\Core\Domain\Model\Value;

use Module\Forum\Core\Domain\Interfaces\IIdentity;

class ID implements IIdentity
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