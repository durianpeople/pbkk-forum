<?php

namespace Module\Forum\Core\Application\Service\Forum;

use Module\Forum\Core\Application\Request\Forum\LeaveForumRequest;
use Module\Forum\Core\Domain\Interfaces\IForumRepository;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Value\ForumID;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Module\Forum\Core\Exception\AdminRemovalException;
use Phalcon\Di\Injectable;

class LeaveForumService extends Injectable
{
    protected $user_repo;
    protected $forum_repo;

    public function __construct(IForumRepository $forum_repo, IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
        $this->forum_repo = $forum_repo;
    }

    public function execute(LeaveForumRequest $request): bool
    {
        $forum = $this->forum_repo->find(new ForumID($request->forum_id));
        $user = $this->user_repo->find(new UserID($request->user_id));
        try {
            $forum->removeMember($user);
        } catch (AdminRemovalException $e) {
            $forum->removeMember($user, true); // do not require user consent
        }

        return $this->forum_repo->persist($forum);
    }
}
