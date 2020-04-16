<?php

namespace Module\Forum\Core\Domain\Record;

use Phalcon\Mvc\Model;

class BansRecord extends Model
{
    public string $user_id;
    public string $forum_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('bans');

        $this->belongsTo(
            'user_id',
            UserRecord::class,
            'id',
            [
                'alias' => 'user'
            ]
        );
        
        $this->belongsTo(
            'forum_id',
            ForumRecord::class,
            'id'
        );
    }
}