<?php

namespace Module\Post\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

class CommentVotesRecord extends Model
{
    public string $voter_id;
    public string $voted_comment_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('comment_votes');
    }
}
