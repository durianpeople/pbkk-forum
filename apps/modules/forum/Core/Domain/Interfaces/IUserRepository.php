<?php

namespace Module\Forum\Core\Domain\Interfaces;

use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\ForumID;
use Module\Forum\Core\Domain\Model\Value\UserID;

interface IUserRepository
{
    public function find(UserID $id): User;
    public function findForumMembers(ForumID $forum_id): array;
    public function persist(User $user): bool;
}
