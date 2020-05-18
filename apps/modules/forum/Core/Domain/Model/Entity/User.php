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
 * @property-read int $awards_count
 */
class User
{
    protected UserID $id;
    protected string $username;
    /** @var Award[] */
    protected array $awards = [];

    public function __construct(UserID $id, string $username)
    {
        assert(ctype_alnum($username), new UsernameAssertionError);

        $this->id = $id;
        $this->username = $username;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'id':
                return $this->id;
            case 'username':
                return $this->username;
            case 'awards_count':
                return count($this->awards);
        }
    }
    
    public function addAward(Award $award)
    {
        foreach ($this->awards as $a) {
            if ($a->awarder_id == $award->awarder_id) throw new DuplicateAwardException;
        }
        $this->awards[] = $award;
    }
}
