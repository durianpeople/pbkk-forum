<?php

namespace Module\Forum\Core\Domain\Record;

use Phalcon\Mvc\Model;

class UserRecord extends Model
{
    public ?int $id;
    public string $username;
    public string $password_hash;

    public function initialize()
    {
        $this->id = null;
        $this->setConnectionService('db');
        $this->setSource('users');
    }
}
