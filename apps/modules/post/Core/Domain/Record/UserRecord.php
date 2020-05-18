<?php

namespace Module\Post\Core\Domain\Record;

use Phalcon\Mvc\Model;

class UserRecord extends Model
{
    public string $id;
    public string $username;
    public string $password_hash;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('users');
    }
}
