<?php

namespace Module\Forum\Core\Application\Service;

use Phalcon\Di\Injectable;

use Module\Forum\Core\Application\Request\RegistrationRequest;

use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\Password;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;

class RegistrationService extends Injectable
{
    public function execute(RegistrationRequest $request): bool
    {
        $user = new User(null, $request->username, Password::createFromString($request->password));

        /** @var IUserRepository */
        $user_repository = $this->getDI()->get('userRepository');
        return $user_repository->persist($user);
    }
}