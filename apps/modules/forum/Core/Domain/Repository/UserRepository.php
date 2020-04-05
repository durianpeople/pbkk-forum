<?php

namespace Module\Forum\Core\Domain\Repository;

use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\Password;
use Module\Forum\Core\Domain\Model\Value\Username;
use Phalcon\Db\Adapter\Pdo\Mysql;

class UserRepository extends AbstractRepository
{
    public function find(Username $username): User
    {
        /** @var Mysql */
        
        return new User(new Username('asd'), new Password('456'));

    }
}
