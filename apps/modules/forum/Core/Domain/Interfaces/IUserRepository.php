<?php

namespace Module\Forum\Core\Domain\Interfaces;

use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\ID;

interface IUserRepository
{
    public function find(ID $id): User;
    public function findByUserPass(string $username, string $password): User;
    public function persist(User $user): bool;
}
