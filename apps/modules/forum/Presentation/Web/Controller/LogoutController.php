<?php

namespace Module\Forum\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

use Module\Forum\Core\Application\Service\LoginService;

class LogoutController extends Controller
{
    public function indexAction()
    {
        $login_service = new LoginService;
        if ($login_service->logout()) {
            $this->response->redirect("/");
        }
    }
}
