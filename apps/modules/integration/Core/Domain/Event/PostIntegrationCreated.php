<?php

namespace Module\Integration\Core\Domain\Event;

use Common\Events\DomainEvent;
use DateTimeImmutable;

/**
 * @property-read string $forum_id
 * @property-read string $post_id
 * @property-read string $title
 * @property-read string $content
 * @property-read string $author_id
 * @property-read string $created_at
 */
class PostIntegrationCreated implements DomainEvent
{
    protected DateTimeImmutable $occured_on;

    protected string $forum_id;
    protected string $post_id;
    protected string $title;
    protected string $content;
    protected string $author_id;
    protected string $created_at;

    public function __construct(
        string $forum_id,
        string $post_id,
        string $title,
        string $content,
        string $author_id,
        string $created_at
    ) {
        $this->forum_id = $forum_id;
        $this->post_id = $post_id;
        $this->title = $title;
        $this->content = $content;
        $this->author_id = $author_id;
        $this->created_at = $created_at; 
        $this->occured_on = new DateTimeImmutable();
    }

    public function occurredOn()
    {
        return $this->occured_on;
    }

    public function __get($name)
    {
        return $this->{$name};
    }
}
