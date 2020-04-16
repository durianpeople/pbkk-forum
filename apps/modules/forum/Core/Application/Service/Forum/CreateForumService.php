<?php

namespace Module\Forum\Core\Application\Service\Forum;

use Module\Forum\Core\Application\Request\Forum\CreateForumRequest;
use Module\Forum\Core\Domain\Interfaces\IForumRepository;
use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Phalcon\Di\Injectable;

class CreateForumService extends Injectable
{
    public function execute(CreateForumRequest $request)
    {
        $forum = Forum::create($request->forum_name, $request->admin_id);

        /** @var IForumRepository */
        $repository = $this->di->get('forumRepository');
        return $repository->persist($forum);
    }
}