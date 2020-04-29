<?php

namespace Module\Forum\Core\Application\Service\Forum;

use Module\Forum\Core\Application\Request\Forum\ViewForumRequest;
use Module\Forum\Core\Application\Response\ForumInfo;
use Module\Forum\Core\Application\Response\UserInfo;
use Module\Forum\Core\Application\Service\User\AuthService;
use Module\Forum\Core\Domain\Interfaces\IForumRepository;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Value\ForumID;
use Phalcon\Di\Injectable;

class ViewForumService
{
    protected $user_repo;
    protected $forum_repo;

    public function __construct(IForumRepository $forum_repo, IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
        $this->forum_repo = $forum_repo;
    }

    public function execute(ViewForumRequest $request): ForumInfo
    {
        $forum = $this->forum_repo->find(new ForumID($request->forum_id));

        $admin = $this->user_repo->find($forum->admin_id);
        $members = $this->user_repo->findForumMembers($forum->id);

        $forum_info = new ForumInfo;

        $admin_info = new UserInfo($admin);

        if ($forum->admin_id->getIdentifier() == $request->user_idd)
            $forum_info->is_admin = true;

        /** @var UserInfo[] */
        $members_info = [];
        foreach ($members as $m) {
            $mi = new UserInfo($m);
            $members_info[] = $mi;

            if ($m->id == $request->user_id)
                $forum_info->joined = true;
        }

        $forum_info->forum_id = $forum->id->getIdentifier();
        $forum_info->forum_name = $forum->name;
        $forum_info->admin = $admin_info;
        $forum_info->members = $members_info;


        return $forum_info;
    }
}