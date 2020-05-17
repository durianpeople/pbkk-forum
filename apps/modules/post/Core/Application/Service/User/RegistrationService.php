<?php

namespace Module\Post\Core\Application\Service\User;

use Phalcon\Di\Injectable;

use Module\Post\Core\Application\Request\User\RegistrationRequest;

use Module\Post\Core\Domain\Model\Entity\User;
use Module\Post\Core\Domain\Interfaces\IUserRepository;

class RegistrationService extends Injectable
{
    public function execute(RegistrationRequest $request): bool
    {
        $user = User::create($request->username, $request->password);

        $user_repository = $this->getDI()->get('userRepository');
        return $user_repository->persist($user);
    }
}
