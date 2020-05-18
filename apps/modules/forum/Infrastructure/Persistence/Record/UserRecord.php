<?php

namespace Module\Forum\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

/**
 * @property-read AwardRecord[] $awards
 */
class UserRecord extends Model
{
    public string $id;
    public string $username;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('users');

        $this->hasMany(
            'id',
            AwardRecord::class,
            'awardee_id',
            [
                'alias' => 'awards'
            ]
        );
    }
}
