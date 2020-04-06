<?php

namespace Module\Forum\Core\Domain\Model\Entity;

use Module\Forum\Core\Domain\Interfaces\IEntity;
use Module\Forum\Core\Domain\Model\Value\Password;
use Module\Forum\Core\Domain\Model\Value\ID;

/**
 * @property-read ID $id
 * @property-read string $username
 * @property-read Password $password
 */
class User implements IEntity
{
    protected ?ID $id;
    protected string $username;
    protected Password $password;

    public static function create(string $username, string $password): User
    {
        return new User(null, $username, Password::createFromString($password));
    }

    public function __construct(ID $id = null, string $username, Password $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'id':
                return $this->id;
            case 'username':
                return $this->username;
            case 'password':
                return $this->password;
        }
    }

    public function changeUsername(string $username) {
        $this->username = $username;
    }

    public function changePassword(string $old_password, Password $new_password)
    {
        if (!$this->password->testAgainst($old_password)) throw new \Exception("Invalid password");
        $this->password = $new_password;
    }
}