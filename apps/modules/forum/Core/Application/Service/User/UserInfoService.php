<?php

namespace Module\Forum\Core\Application\Service\User;

use Module\Forum\Core\Application\Request\User\UserInfoRequest;
use Module\Forum\Core\Application\Response\UserInfo;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Value\UserID;

class UserInfoService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(UserInfoRequest $request): UserInfo
    {
        $user = $this->user_repo->find(new UserID($request->user_id));
        return new UserInfo($user);
    }
}
