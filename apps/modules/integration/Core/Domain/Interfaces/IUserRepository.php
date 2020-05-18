<?php

namespace Module\Integration\Core\Domain\Interfaces;

use Module\Integration\Core\Domain\Model\User;
use Module\Integration\Core\Domain\Model\UserID;

interface IUserRepository
{
    public function find(UserID $id): User;
    public function findByUserPass(string $username, string $password): User;
    public function persist(User $user): bool;
}
