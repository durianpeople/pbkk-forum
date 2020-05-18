<?php

namespace Module\Forum\Core\Application\Response;

use Module\Forum\Core\Domain\Model\Entity\User;

class UserInfo
{
    public string $id;
    public string $username;
    public int $awards_count = 0;

    public function __construct(User $user)
    {
        $this->id = $user->id->getIdentifier();
        $this->username = $user->username;
        $this->awards_count = $user->awards_count;
    }
}
