<?php

namespace Module\Integration\Core\Domain\Model;

use Common\Events\DomainEventPublisher;
use DateTime;
use Module\Integration\Core\Domain\Event\PostIntegrationCreated;

/**
 * @property-read ForumID $forum_id
 * @property-read PostID $id
 * @property-read string $title
 * @property-read string $content
 * @property-read UserID $author_id
 * @property-read DateTime $created_date
 */
class Post
{
    protected ForumID $forum_id;
    protected PostID $id;
    protected string $title;
    protected string $content;
    protected UserID $author_id;
    protected DateTime $created_date;

    public static function create(ForumID $forum_id, string $title, string $content, UserID $author_id): Post
    {
        // return new self($forum_id, PostID::generate(), $title, $content, $author_id, date('F j, Y, g:i a', time()));
        $post_id = PostID::generate();
        $datetime = new DateTime();
        DomainEventPublisher::instance()->publish(
            new PostIntegrationCreated(
                $forum_id->getIdentifier(),
                $post_id->getID(),
                $title,
                $content,
                $author_id->getIdentifier(),
                $datetime->format('F j, Y, g:i a')
            )
        );
        return new self($forum_id, $post_id, $title, $content, $author_id, $datetime);
    }

    public function __construct(ForumID $forum_id, PostID $id, string $title, string $content, UserID $author_id, DateTime $created_at)
    {
        $this->forum_id = $forum_id;
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->author_id = $author_id;
        $this->created_date = $created_at;
    }

    public function __get($val)
    {
        switch ($val) {
            case 'forum_id':
                return $this->forum_id;
            case 'id':
                return $this->id;
            case 'title':
                return $this->title;
            case 'content':
                return $this->content;
            case 'author_id':
                return $this->author_id;
            case 'created_date            ':
                return $this->created_date;
        }
    }
}
