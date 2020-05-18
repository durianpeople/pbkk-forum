<?php

namespace Module\Forum\Core\Application\Service\Forum;

use Module\Forum\Core\Application\Request\Forum\CreateForumRequest;

use Module\Forum\Core\Domain\Interfaces\IForumRepository;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Value\UserID;

class CreateForumService
{
    protected $user_repo;
    protected $forum_repo;

    public function __construct(IForumRepository $forum_repo, IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
        $this->forum_repo = $forum_repo;
    }

    public function execute(CreateForumRequest $request): bool
    {
        $user = $this->user_repo->find(new UserID($request->admin_id));

        $forum = Forum::create($request->forum_name, $user);

        return $this->forum_repo->persist($forum);
    }
}