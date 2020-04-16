<?php

namespace Module\Forum\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

use Module\Forum\Core\Application\Service\User\AuthService;

class LogoutController extends Controller
{
    public function indexAction()
    {
        $auth_service = new AuthService;
        if ($auth_service->logout()) {
            $this->response->redirect("/");
        }
    }
}
