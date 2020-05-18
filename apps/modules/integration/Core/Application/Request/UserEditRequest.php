<?php

namespace Module\Integration\Core\Application\Request;

class UserEditRequest
{
    public string $user_id;
    public ?string $username;
    public ?string $old_password;
    public ?string $new_password;
}
