<?php

namespace Module\Post\Core\Domain\Interfaces;

use Module\Post\Core\Domain\Model\Entity\User;
use Module\Post\Core\Domain\Model\Value\UserID;

interface IUserRepository
{
    public function findByID(UserID $id): User;
    public function findByUserPass(string $username, string $password): User;
    public function persist(User $user): bool;
}
