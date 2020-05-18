<?php

namespace Module\Integration\Core\Application\Service;

use Module\Integration\Core\Application\Request\LoginRequest;
use Module\Integration\Core\Application\Response\UserInfo;
use Module\Integration\Core\Domain\Interfaces\IUserRepository;

class AuthService
{
    protected $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(LoginRequest $request): UserInfo
    {
        $user = $this->user_repo->findByUserPass($request->username, $request->password);
        return new UserInfo($user);
    }
}
