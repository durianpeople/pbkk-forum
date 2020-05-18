<?php

namespace Module\Post\Core\Application\Service\User;

use Phalcon\Di\Injectable;

use Module\Post\Core\Application\Request\User\LoginRequest;
use Module\Post\Core\Application\Response\User\UserInfo;

use Module\Post\Core\Domain\Interfaces\IUserRepository;
use Module\Post\Core\Domain\Model\Entity\User;

class AuthService extends Injectable
{
    public function getUserRepository()
    {
        return $this->getDI()->get('userRepository');
    }

    public function execute(LoginRequest $request): bool
    {
        $user = $this->getUserRepository()->findByUserPass($request->username, $request->password);
        $this->session->set('user_id', $user->id);

        return true;
    }

    public function isLoggedIn(): bool
    {
        return $this->session->has('user_id');
    }

    public function getUser(): ?User
    {
        if ($this->isLoggedIn()) {
            $user = $this->getUserRepository()->findByID($this->session->get('user_id'));
            return $user;
        }
        return null;
    }

    public function getUserInfo(): ?UserInfo
    {
        if ($this->isLoggedIn()) {
            $user = $this->getUser();
            $user_info = new UserInfo();
            $user_info->id = $user->id->getID();
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
