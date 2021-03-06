<?php

namespace Module\Forum\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;

/**
 * @property-read BansRecord[] $banned_members
 */
class ForumRecord extends Model
{
    public string $id;
    public string $name;
    public string $admin_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('forums');

        $this->hasManyToMany(
            'id',
            BansRecord::class,
            'forum_id',
            'user_id',
            UserRecord::class,
            'id',
            [
                'alias' => 'banned_members'
            ]
        );
    }
}
