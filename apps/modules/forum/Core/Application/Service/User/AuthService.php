<?php

namespace Module\Forum\Core\Application\Service\User;

use Phalcon\Di\Injectable;

use Module\Forum\Core\Application\Request\User\LoginRequest;
use Module\Forum\Core\Application\Response\UserInfo;

use Module\Forum\Core\Domain\Interfaces\IUserRepository;

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
