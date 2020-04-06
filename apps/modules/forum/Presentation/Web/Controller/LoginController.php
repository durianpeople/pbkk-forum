<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Request\LoginRequest;
use Module\Forum\Core\Application\Service\LoginService;
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        if ($this->request->isPost()) {
            $this->view->disable();
            $request = new LoginRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');

            $login_service = new LoginService;
            if ($login_service->execute($request)) {
                $this->response->redirect('/');
            }
        }
    }
}
