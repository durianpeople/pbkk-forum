<?php

namespace Module\Forum\Core\Domain\Record;

use Phalcon\Mvc\Model;

/**
 * @property-read AwardRecord[] $awards
 * @property-read Forum[] $adminned_forums
 * @property-read Forum[] $joined_forums
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
