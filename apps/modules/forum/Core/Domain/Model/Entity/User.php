<?php

namespace Module\Forum\Core\Domain\Model\Entity;

use Module\Dashboard\Core\Domain\Model\Value\Credential;
use Module\Dashboard\Core\Domain\Model\Value\Username;

class User
{
    protected $username;
    protected $name;
    protected $credential;

    protected $__is_authenticated = false;

    public function __construct(Username $username, string $name, Credential $credential)
    {
        $this->username = $username;
        $this->name = $name;
        $this->credential = $credential;
    }

    public function changeCredential(Credential $old_credential, Credential $new_credential)
    {
        if ($this->credential != $old_credential) throw new \Exception("Invalid credential");
        $this->credential = $new_credential;
    }
}