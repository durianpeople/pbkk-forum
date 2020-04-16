<?php

namespace Module\Forum\Core\Application\Service\User;

use Phalcon\Di\Injectable;

use Module\Forum\Core\Application\Request\User\UserEditRequest;

use Module\Forum\Core\Domain\Model\Value\Password;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;

class UserEditService extends Injectable
{
    public function execute(UserEditRequest $request): bool
    {
        $user = $request->user;
        if (isset($request->username)) {
            $user->changeUsername($request->username);
        }

        if (isset($request->new_password)) {
            $user->changePassword($request->old_password, Password::createFromString($request->new_password));
        }

        /** @var IUserRepository */
        $user_repository = $this->getDI()->get('userRepository');
        return $user_repository->persist($user);
    }
}