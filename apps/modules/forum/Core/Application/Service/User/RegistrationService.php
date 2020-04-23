<?php

namespace Module\Forum\Core\Application\Service\User;

use Phalcon\Di\Injectable;

use Module\Forum\Core\Application\Request\User\RegistrationRequest;

use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;

class RegistrationService extends Injectable
{
    public function execute(RegistrationRequest $request): bool
    {
        $user = User::create($request->username, $request->password);

        /** @var IUserRepository */
        $user_repository = $this->getDI()->get('userRepository');
        return $user_repository->persist($user);
    }
}