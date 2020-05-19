<?php

namespace Module\Integration\Infrastructure\Persistence\Record;

use Module\Post\Infrastructure\Persistence\Record\PostVotesRecord;
use Module\Post\Infrastructure\Persistence\Record\UserRecord;
use Phalcon\Mvc\Model;

/**
 * @method integer countVotes()
 * @property-read PostForumRecord $post_forum
 */
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

        $this->hasManytoMany(
            'id',
            PostVotesRecord::class,
            'voted_post_id',
            'voter_id',
            UserRecord::class,
            'id',
            [
                'alias' => 'votes'
            ]
        );

        $this->hasOne(
            'id',
            PostForumRecord::class,
            'post_id',
            [
                'alias' => 'post_forum'
            ]
        );
    }
}
