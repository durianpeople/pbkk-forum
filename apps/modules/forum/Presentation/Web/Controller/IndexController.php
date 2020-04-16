<?php

namespace Module\Forum\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

use Module\Forum\Core\Application\Service\User\AuthService;

class IndexController extends Controller
{
    public function indexAction()
    {
        $auth_service = new AuthService;

        if (!$auth_service->isLoggedIn()) {
            $this->view->setVar('loggedin', false);
        } else {
            $user_info = $auth_service->getUserInfo();
            $this->view->setVar('loggedin', true);
            $this->view->setVar('user_info', $user_info);
        }
    }
}
