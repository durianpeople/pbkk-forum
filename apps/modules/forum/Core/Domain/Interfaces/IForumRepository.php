<?php

namespace Module\Forum\Core\Domain\Interfaces;

use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\ForumID;
use Module\Forum\Core\Domain\Model\Value\UserID;

interface IForumRepository
{
    public function find(ForumID $id): Forum;
    /**
     * @param User $user
     * @return Forum[]
     */
    public function findAdminnedForums(UserID $user_id): array;
    /**
     * @param User $user
     * @return Forum[]
     */
    public function findJoinedForums(UserID $user_id): array;
    public function persist(Forum $forum): bool;
}
