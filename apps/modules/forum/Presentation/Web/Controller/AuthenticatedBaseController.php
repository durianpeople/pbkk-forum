<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Response\UserInfo;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Phalcon\Mvc\Controller;

abstract class AuthenticatedBaseController extends Controller
{
    protected IUserRepository $user_repo;
    protected UserInfo $user_info;

    public function beforeExecuteRoute()
    {
        if (!$this->session->has('user_info')) {
            $this->response->redirect("/login")->send();
            return false;
        }
        return true;
    }

    public function initialize()
    {
        $this->user_repo = $this->di->get('userRepository');
        /** @var UserInfo */
        $user_info = $this->session->get('user_info');

        // Renew user info
        $user = $this->user_repo->find(new UserID($user_info->id));
        $this->user_info = new UserInfo($user);
    }

    protected function logout()
    {
        return $this->session->destroy('user_info');
    }
}
