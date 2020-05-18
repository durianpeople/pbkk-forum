<?php

namespace Module\Integration\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

/**
 * @property-read BansRecord[] $banned_members
 */
class ForumRecord extends Model
{
    public string $id;
    public string $name;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('forums');
    }
}
