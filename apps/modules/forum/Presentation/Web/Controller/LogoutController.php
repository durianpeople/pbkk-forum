<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Service\LoginService;
use Phalcon\Mvc\Controller;

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
