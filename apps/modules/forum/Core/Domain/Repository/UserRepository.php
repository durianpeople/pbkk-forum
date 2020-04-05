<?php

namespace Module\Forum\Core\Domain\Repository;

use Module\Dashboard\Core\Domain\Model\Entity\User;
use Module\Dashboard\Core\Domain\Model\Value\Username;
use Phalcon\Db\Adapter\Pdo\Mysql;

class UserRepository extends AbstractRepository
{
    public function find(Username $username): User
    {
        /** @var Mysql */
        $db = $this->getDI()->get('db');
    }
}
