<?php

namespace Module\Forum\Core\Domain\Record;

use Phalcon\Mvc\Model;

class AwardRecord extends Model
{
    public string $awarder_id;
    public string $awardee_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('awards');

        $this->belongsTo(
            'awarder_id',
            UserRecord::class,
            'id'
        );
        
        $this->belongsTo(
            'awardee_id',
            UserRecord::class,
            'id'
        );
    }
}