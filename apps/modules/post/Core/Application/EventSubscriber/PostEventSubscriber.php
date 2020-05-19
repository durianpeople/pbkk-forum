<?php

namespace Module\Post\Core\Application\EventSubscriber;

use Common\Events\DomainEventSubscriber;
use Module\Integration\Core\Domain\Event\PostIntegrationCreated;
use Module\Post\Core\Domain\Interfaces\IPostRepository;
use Module\Post\Core\Domain\Model\Entity\Post;
use Module\Post\Core\Domain\Model\Value\PostID;
use Module\Post\Core\Domain\Model\Value\UserID;

class PostEventSubscriber implements DomainEventSubscriber
{
    protected IPostRepository $post_repo;

    public function __construct(IPostRepository $post_repo)
    {
        $this->post_repo = $post_repo;
    }

    public function handle($aDomainEvent)
    {
        switch (true) {
            case $aDomainEvent instanceof PostIntegrationCreated:
                /** @var PostIntegrationCreated $aDomainEvent */
                $post = new Post(new PostID($aDomainEvent->post_id), $aDomainEvent->title, $aDomainEvent->content, new UserID($aDomainEvent->author_id), $aDomainEvent->created_at);
                $this->post_repo->persist($post);
                break;
        }
    }

    public function isSubscribedTo($aDomainEvent)
    {
        switch (true) {
            case $aDomainEvent instanceof PostIntegrationCreated:
                return true;
            default:
                return false;
        }
    }
}
