<?php

namespace Module\Integration\Core\Application\Response;

use Module\Integration\Core\Domain\Model\User;

class UserInfo
{
    public string $id;
    public string $username;

    public function __construct(User $user)
    {
        $this->id = $user->id->getIdentifier();
        $this->username = $user->username;
    }
}
