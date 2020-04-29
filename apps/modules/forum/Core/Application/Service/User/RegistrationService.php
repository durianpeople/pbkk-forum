<?php

namespace Module\Forum\Core\Application\Service\User;

use Phalcon\Di\Injectable;

use Module\Forum\Core\Application\Request\User\RegistrationRequest;

use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;

class RegistrationService extends Injectable
{
    protected $user_repo;

    public function __construct(IUserRepository $user_repo)
    {
        $this->user_repo = $user_repo;
    }

    public function execute(RegistrationRequest $request): bool
    {
        $user = User::create($request->username, $request->password);

        return $this->user_repo->persist($user);
    }
}