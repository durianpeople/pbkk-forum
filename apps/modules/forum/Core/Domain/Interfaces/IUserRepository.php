<?php

namespace Module\Forum\Core\Domain\Interfaces;

use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\UserID;

interface IUserRepository
{
    public function find(UserID $id): User;
    public function findByUserPass(string $username, string $password): User;
    public function getForumMembers(Forum $forum): array;
    public function persist(User $user): bool;
}
