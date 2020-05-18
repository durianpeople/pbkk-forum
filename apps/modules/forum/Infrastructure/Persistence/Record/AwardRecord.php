<?php

namespace Module\Forum\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

class AwardRecord extends Model
{
    public string $awarder_id;
    public string $awardee_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('awards');
    }
}