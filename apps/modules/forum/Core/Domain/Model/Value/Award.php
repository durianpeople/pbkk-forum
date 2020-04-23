<?php

namespace Module\Forum\Core\Domain\Model\Value;

use Module\Forum\Core\Domain\Model\Entity\User;

/**
 * @property-read User $awarder
 */
class Award
{
    protected User $awarder;

    public function __construct(User $awarder)
    {
        $this->awarder = $awarder;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'awarder':
                return $this->awarder;
        }
    }
}