<?php

namespace Module\Forum\Core\Domain\Repository;

use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\Username;

class UserRepository extends AbstractRepository
{
    public function find(Username $username): User
    {
        
    }
}
