<?php

namespace Module\Forum\Core\Application\Service\Forum;

use Module\Forum\Core\Application\Request\Forum\JoinForumRequest;

use Module\Forum\Core\Domain\Interfaces\IForumRepository;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Value\ForumID;
use Module\Forum\Core\Domain\Model\Value\UserID;

class JoinForumService
{
    protected $user_repo;
    protected $forum_repo;

    public function __construct(IForumRepository $forum_repo, IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
        $this->forum_repo = $forum_repo;
    }

    public function execute(JoinForumRequest $request): bool
    {
        $forum = $this->forum_repo->find(new ForumID($request->forum_id));
        $user = $this->user_repo->find(new UserID($request->user_id));

        if ($forum->addMember($user)) {
            return $this->forum_repo->persist($forum);
        }
        return false;
    }
}
