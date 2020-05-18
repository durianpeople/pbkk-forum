<?php

namespace Module\Integration\Core\Domain\Model;

use Module\Integration\Core\Exception\UsernameAssertionError;
use Module\Integration\Core\Exception\WrongPasswordException;

/**
 * @property-read UserID $id
 * @property-read string $username
 * @property-read Password $password
 */
class User
{
    protected UserID $id;
    protected string $username;
    protected Password $password;

    public static function create(string $username, string $password): User
    {
        return new User(UserID::generate(), $username, Password::createFromString($password));
    }

    public function __construct(UserID $id, string $username, Password $password)
    {
        assert(ctype_alnum($username), new UsernameAssertionError);

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

    public function changeUsername(string $username)
    {
        assert(ctype_alnum($username), new UsernameAssertionError);

        $this->username = $username;
    }

    public function changePassword(string $old_password, Password $new_password)
    {
        if (!$this->password->testAgainst($old_password)) throw new WrongPasswordException;
        $this->password = $new_password;
    }
}
