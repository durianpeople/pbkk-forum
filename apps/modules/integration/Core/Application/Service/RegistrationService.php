<?php

namespace Module\Integration\Core\Application\Service;

use Module\Integration\Core\Application\Request\RegistrationRequest;
use Module\Integration\Core\Domain\Interfaces\IUserRepository;
use Module\Integration\Core\Domain\Model\User;

class RegistrationService
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
