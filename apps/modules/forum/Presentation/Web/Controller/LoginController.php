<?php

namespace Module\Forum\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

use Module\Forum\Core\Application\Request\User\LoginRequest;
use Module\Forum\Core\Application\Service\User\AuthService;

class LoginController extends Controller
{
    public function indexAction()
    {
        if ($this->request->isPost()) {
            $this->view->disable();
            $request = new LoginRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');

            $auth_service = new AuthService;
            if ($auth_service->execute($request)) {
                $this->response->redirect('/');
            }
        }
    }
}
