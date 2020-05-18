<?php

namespace Module\Post\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

class PostVotesRecord extends Model
{
    public string $voter_id;
    public string $voted_post_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('post_votes');
    }
}
