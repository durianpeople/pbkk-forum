<?php

namespace Module\Forum\Core\Domain\Model\Entity;

use Module\Forum\Core\Domain\Model\Value\Password;
use Module\Forum\Core\Domain\Model\Value\Username;

class User implements IEntity
{
    protected $username;
    protected $password;

    protected $__is_authenticated = false;

    public function __construct(Username $username, Password $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function changePassword(Password $old_password, Password $new_password)
    {
        if ($this->password != $old_password) throw new \Exception("Invalid password");
        $this->password = $new_password;
    }
}