<?php

namespace Module\Forum\Core\Application\Service\Forum;

use Module\Forum\Core\Application\Request\Forum\ViewForumRequest;
use Module\Forum\Core\Application\Response\ForumInfo;
use Module\Forum\Core\Application\Response\UserInfo;
use Module\Forum\Core\Domain\Interfaces\IForumRepository;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Value\ForumID;
use Phalcon\Di\Injectable;

class ViewForumService extends Injectable
{
    public function execute(ViewForumRequest $request): ForumInfo
    {
        /** @var IForumRepository */
        $forum_repo = $this->di->get('forumRepository');

        $forum = $forum_repo->find(new ForumID($request->forum_id));

        /** @var IUserRepository */
        $user_repo = $this->di->get('userRepository');

        $admin = $user_repo->find($forum->admin_id);
        $members = $user_repo->findForumMembers($forum->id);

        $admin_info = new UserInfo;
        $admin_info->id = $admin->id->getIdentifier();
        $admin_info->username = $admin->username;

        /** @var UserInfo[] */
        $members_info = [];
        foreach ($members as $m) {
            $mi = new UserInfo;
            $mi->id = $m->id->getIdentifier();
            $mi->username = $m->username;
            $members_info[] = $mi;
        }

        $forum_info = new ForumInfo;
        $forum_info->forum_name = $forum->name;
        $forum_info->admin = $admin_info;
        $forum_info->members = $members_info;

        return $forum_info;
    }
}