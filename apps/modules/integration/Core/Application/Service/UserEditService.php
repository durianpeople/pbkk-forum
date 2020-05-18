<?php

namespace Module\Integration\Core\Application\Service;

use Module\Integration\Core\Application\Request\UserEditRequest;
use Module\Integration\Core\Domain\Interfaces\IUserRepository;
use Module\Integration\Core\Domain\Model\Password;
use Module\Integration\Core\Domain\Model\UserID;

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
