<?php

namespace Module\Post\Core\Domain\Record;

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
