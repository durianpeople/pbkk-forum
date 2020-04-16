<?php

namespace Module\Forum\Core\Domain\Record;

use Phalcon\Mvc\Model;

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
    }
}
