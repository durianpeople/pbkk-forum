<?php

namespace Module\Forum\Core\Domain\Model\Entity;

use Module\Forum\Core\Domain\Model\Value\Award;
use Module\Forum\Core\Domain\Model\Value\Password;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Module\Forum\Core\Exception\DuplicateAwardException;
use Module\Forum\Core\Exception\UsernameAssertionError;
use Module\Forum\Core\Exception\WrongPasswordException;

/**
 * @property-read UserID $id
 * @property-read string $username
 * @property-read Password $password
 * @property-read int $awards_count
 */
class User
{
    protected UserID $id;
    protected string $username;
    protected Password $password;
    /** @var Award[] */
    protected array $awards = [];

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
            case 'awards_count':
                return count($this->awards);
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

    public function addAward(Award $award)
    {
        foreach ($this->awards as $a) {
            if ($a->awarder_id == $award->awarder_id) throw new DuplicateAwardException;
        }
        $this->awards[] = $award;
    }
}
