<?php

namespace Module\Forum\Core\Domain\Interfaces;

use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\ID;
use Module\Forum\Core\Domain\Model\Value\Password;

interface IUserRepository extends IRepository
{
    public function find(ID $id): User;
    public function findByUserPass(string $username, Password $password): User;
    public function persist(User $user);
}
