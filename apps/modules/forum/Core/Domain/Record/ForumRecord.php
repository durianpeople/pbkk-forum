<?php

namespace Module\Forum\Core\Domain\Record;

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

        $this->belongsTo(
            'admin_id',
            UserRecord::class,
            'id'
        );

        $this->hasMany(
            'id',
            MembersRecord::class,
            'forum_id'
        );
        
        $this->hasManyToMany(
            'id',
            MembersRecord::class,
            'forum_id',
            'user_id',
            UserRecord::class,
            'id'
        );

        $this->hasMany(
            'id',
            BansRecord::class,
            'forum_id'
        );
        
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