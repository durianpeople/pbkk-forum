<?php

namespace Module\Forum\Infrastructure\Persistence;

use Phalcon\Mvc\Model;

class UserEntry extends Model
{
    public string $username;
    public string $password;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('users');
    }
}