<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Service\LoginService;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $login_service = new LoginService;

        if (!$login_service->isLoggedIn()) {
            $this->view->setVar('loggedin', false);
        } else {
            $user_info = $login_service->getLoggedInUserInfo();
            $this->view->setVar('loggedin', true);
            $this->view->setVar('user_info', $user_info);
        }
    }
}
