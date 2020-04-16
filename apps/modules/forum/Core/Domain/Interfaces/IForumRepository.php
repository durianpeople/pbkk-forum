<?php

namespace Module\Forum\Core\Domain\Interfaces;

use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\ForumID;

interface IForumRepository
{
    public function find(ForumID $id): Forum;
    public function findAdminnedForums(User $user): array;
    public function persist(Forum $forum): bool;
}
