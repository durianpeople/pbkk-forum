<?php

namespace Module\Integration\Core\Application\Service;

use Module\Integration\Core\Application\Request\UserInfoRenewalRequest;
use Module\Integration\Core\Application\Response\UserInfo;
use Module\Integration\Core\Domain\Interfaces\IUserRepository;
use Module\Integration\Core\Domain\Model\UserID;

class UserInfoRenewalService
{
    protected IUserRepository $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(UserInfoRenewalRequest $request)
    {
        $user = $this->user_repo->find(new UserID($request->user_info->id));
        return new UserInfo($user);
    }
}
