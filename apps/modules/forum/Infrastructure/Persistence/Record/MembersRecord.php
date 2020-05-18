<?php

namespace Module\Forum\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;
use Module\Forum\Infrastructure\Persistence\Record\UserRecord;

/**
 * @property-read UserRecord $user
 * @property-read ForumRecord $forum
 */
class MembersRecord extends Model
{
    public string $user_id;
    public string $forum_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('members');

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
            'id',
            [
                'alias' => 'forum'
            ]
        );
    }
}
