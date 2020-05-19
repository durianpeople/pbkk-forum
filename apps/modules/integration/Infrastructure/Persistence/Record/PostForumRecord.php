<?php

namespace Module\Integration\Infrastructure\Persistence\Record;

use Phalcon\Mvc\Model;

/**
 * @property-read PostRecord $post
 */
class PostForumRecord extends Model
{
    public string $forum_id;
    public string $post_id;

    public function initialize()
    {
        $this->setConnectionService('db');
        $this->setSource('post_forum');

        $this->belongsTo(
            'post_id',
            PostRecord::class,
            'id',
            [
                'alias' => 'post'
            ]
        );
    }
}
