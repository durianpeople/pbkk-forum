<?php

namespace Module\Integration\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

class PostRecord extends Model
{
    public string $forum_id;
    public string $id;
    public string $title;
    public string $content;
    public string $author_id;
    public string $created_date;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('posts');
    }
}
