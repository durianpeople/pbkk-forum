<?php

namespace Module\Forum\Core\Application\Service\User;

use Module\Forum\Core\Application\Request\User\UserEditRequest;

use Module\Forum\Core\Domain\Model\Value\Password;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Value\UserID;

class UserEditService
{
    protected $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(UserEditRequest $request): bool
    {
        $user = $this->user_repo->find(new UserID($request->user_id));
        
        if (isset($request->username)) {
            $user->changeUsername($request->username);
        }

        if (isset($request->new_password)) {
            $user->changePassword($request->old_password, Password::createFromString($request->new_password));
        }

        return $this->user_repo->persist($user);
    }
}