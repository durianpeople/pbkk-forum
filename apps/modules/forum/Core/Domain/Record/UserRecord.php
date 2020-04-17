<?php

namespace Module\Forum\Core\Domain\Record;

use Phalcon\Mvc\Model;

/**
 * @property-read AwardRecord[] $awards
 */
class UserRecord extends Model
{
    public string $id;
    public string $username;
    public string $password_hash;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('users');

        $this->hasOne(
            'id',
            ForumRecord::class,
            'admin_id'
        );

        $this->hasMany(
            'id',
            MembersRecord::class,
            'user_id'
        );

        $this->hasManyToMany(
            'id',
            MembersRecord::class,
            'user_id',
            'forum_id',
            ForumRecord::class,
            'id'
        );

        $this->hasMany(
            'id',
            AwardRecord::class,
            'awardee_id',
            [
                'alias' => 'awards'
            ]
        );

        $this->hasManyToMany(
            'id',
            AwardRecord::class,
            'awardee_id',
            'awarder_id',
            UserRecord::class,
            'id'
        );

        $this->hasMany(
            'id',
            AwardRecord::class,
            'awarder_id'
        );

        $this->hasManyToMany(
            'id',
            AwardRecord::class,
            'awarder_id',
            'awardee_id',
            UserRecord::class,
            'id'
        );
    }
}
