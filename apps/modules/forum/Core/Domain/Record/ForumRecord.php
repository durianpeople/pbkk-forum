<?php

namespace Module\Forum\Core\Domain\Record;

use Phalcon\Mvc\Model;

class ForumRecord extends Model
{
    public string $id;
    public string $name;
    public int $admin_id;

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
            UserForumRecord::class,
            'forum_id'
        );
        
        $this->hasManyToMany(
            'id',
            UserForumRecord::class,
            'forum_id',
            'user_id',
            UserRecord::class,
            'id'
        );
    }
}