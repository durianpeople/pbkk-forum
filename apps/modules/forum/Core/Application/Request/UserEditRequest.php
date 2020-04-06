<?php

namespace Module\Forum\Core\Application\Request;

use Module\Forum\Core\Application\Interfaces\IRequest;

class UserEditRequest
{
    public ?string $username;
    public ?string $old_password;
    public ?string $new_password;
}