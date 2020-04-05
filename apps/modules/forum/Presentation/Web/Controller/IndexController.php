<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Request\RegistrationRequest;
use Module\Forum\Core\Application\Service\UserService;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->dumper = 'Hellow';
    }

    public function registerAction()
    {
        if ($this->request->isPost()) {
            $request = new RegistrationRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');

            $user_service = new UserService();
            // $user_service->setDI($this->getDI());
            if ($user_service->register($request)) {
                $this->view->message = "Sukses";
                $this->response->setStatusCode(200, 'OK');
            } else {
                $this->view->message = "Gagal";
                $this->response->setStatusCode(400, 'Bad request');
            }
        } else {
            $this->view->message = "Gagal";
            $this->response->setStatusCode(400, 'Bad request');
        }
    }
}
