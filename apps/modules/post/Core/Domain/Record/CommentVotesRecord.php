<?php

namespace Module\Post\Core\Domain\Record;

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
