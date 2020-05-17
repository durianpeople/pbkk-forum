<?php

namespace Module\Post\Core\Domain\Record;

use Phalcon\Mvc\Model;

class PostRecord extends Model
{
    public string $id;
    public string $title;
    public string $content;
    public string $author_id;
    public string $created_date;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('posts');

        $this->hasManytoMany(
          'id',
          PostVotesRecord::class,
          'voted_post_id',
          'voter_id',
          UserRecord::class,
          'id',
          [
            'alias' => 'voted_members'
          ]
        );
        $this->hasMany(
          'id',
          CommentRecord::class,
          'post_id',
          [
            'alias' => 'comments'
          ]
        );
    }

}
