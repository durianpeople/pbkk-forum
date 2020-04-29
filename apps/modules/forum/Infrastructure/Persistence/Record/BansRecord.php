<?php

namespace Module\Forum\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

class BansRecord extends Model
{
    public string $user_id;
    public string $forum_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('bans');
    }
}