<?php

namespace Module\Forum\Core\Application\Service\Forum;

use Module\Forum\Core\Application\Request\Forum\CreateForumRequest;
use Module\Forum\Core\Domain\Interfaces\IForumRepository;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Phalcon\Di\Injectable;

class CreateForumService extends Injectable
{
    public function execute(CreateForumRequest $request): bool
    {
        /** @var IUserRepository */
        $user_repository = $this->di->get('userRepository');
        $user = $user_repository->find(new UserID($request->admin_id));

        $forum = Forum::create($request->forum_name, $user);

        /** @var IForumRepository */
        $forum_repository = $this->di->get('forumRepository');
        return $forum_repository->persist($forum);
    }
}