<?php

namespace Module\Forum\Core\Domain\Model\Value;

use Module\Forum\Core\Domain\Model\Entity\User;

/**
 * @property-read UserID $awarder_id
 */
class Award
{
    protected UserID $awarder_id;

    public function __construct(UserID $awarder_id)
    {
        $this->awarder_id = $awarder_id;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'awarder_id':
                return $this->awarder_id;
        }
    }
}
