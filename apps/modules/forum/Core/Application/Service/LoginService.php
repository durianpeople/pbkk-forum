<?php

namespace Module\Forum\Core\Application\Service;

use Phalcon\Di\Injectable;

use Module\Forum\Core\Application\Request\LoginRequest;
use Module\Forum\Core\Application\Response\UserInfo;

use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Entity\User;

class LoginService extends Injectable
{
    public function execute(LoginRequest $request): bool
    {
        /** @var IUserRepository */
        $user_repository = $this->getDI()->get('userRepository');
        $user = $user_repository->findByUserPass($request->username, $request->password);
        $this->session->set('userid', $user->id);

        return true;
    }

    public function isLoggedIn(): bool
    {
        return $this->session->has('userid');
    }

    /**
     * Get logged in user object
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->isLoggedIn()) {
            /** @var IUserRepository */
            $user_repository = $this->getDI()->get('userRepository');
            $user = $user_repository->find($this->session->get('userid'));

            return $user;
        }
        return null;
    }

    /**
     * Get logged in user info
     *
     * @return UserInfo|null
     */
    public function getUserInfo(): ?UserInfo
    {
        if ($this->isLoggedIn()) {
            $user = $this->getUser();
            $user_info = new UserInfo();
            $user_info->username = $user->username;

            return $user_info;
        }
        return null;
    }

    public function logout(): bool
    {
        $this->session->destroy();
        return true;
    }
}
