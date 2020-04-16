<?php

namespace Module\Forum\Core\Application\Request\User;

use Module\Forum\Core\Domain\Model\Entity\User;

class UserEditRequest
{
    public int $user_id;
    public ?string $username;
    public ?string $old_password;
    public ?string $new_password;
}