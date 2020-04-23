<?php

namespace Module\Forum\Core\Application\Service\Forum;

use Module\Forum\Core\Application\Request\Forum\BanMemberRequest;
use Module\Forum\Core\Domain\Interfaces\IForumRepository;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Value\ForumID;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Phalcon\Di\Injectable;

class BanMemberService extends Injectable
{
    public function execute(BanMemberRequest $request): bool
    {
        /** @var IForumRepository */
        $forum_repository = $this->di->get('forumRepository');

        /** @var IUserRepository */
        $user_repository = $this->di->get('userRepository');

        $forum = $forum_repository->find(new ForumID($request->forum_id));
        $user = $user_repository->find(new UserID($request->user_id));

        $forum->removeMember($user);
        $forum->banMember($user);

        
        $forum_repository->persist($forum);
        return true;
    }
}
