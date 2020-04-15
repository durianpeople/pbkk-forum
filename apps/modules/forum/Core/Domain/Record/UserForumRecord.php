<?php

namespace Module\Forum\Core\Domain\Record;

use Phalcon\Mvc\Model;
use Module\Forum\Core\Domain\Record\UserRecord;

/**
 * @property-read UserRecord $user
 */
class UserForumRecord extends Model
{
    public string $user_id;
    public string $forum_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('user_forum');

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