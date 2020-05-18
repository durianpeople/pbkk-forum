<?php

namespace Module\Post\Core\Domain\Record;

use Phalcon\Mvc\Model;

class CommentRecord extends Model
{
    public string $id;
    public string $content;
    public string $author_id;
    public string $post_id;
    public string $created_date;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('comments');

        $this->hasManytoMany(
            'id',
            CommentVotesRecord::class,
            'voted_comment_id',
            'voter_id',
            UserRecord::class,
            'id',
            [
                'alias' => 'voted_members'
            ]
        );
    }
}
