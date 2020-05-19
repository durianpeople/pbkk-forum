<?php

namespace Module\Integration\Presentation\Web\Controller;

use Module\Integration\Core\Application\Request\RegistrationRequest;
use Module\Integration\Core\Application\Service\RegistrationService;
use Phalcon\Mvc\Controller;

class RegisterController extends Controller
{
    protected RegistrationService $service;

    public function initialize()
    {
        $this->service = $this->di->get('registrationService');
    }

    public function indexAction()
    {
        if ($this->request->isPost()) {
            $request = new RegistrationRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');

            if ($this->service->execute($request)) {
                $this->flashSession->success("Registrasi berhasil");
                $this->response->redirect("/login");
            } else {
                $this->flashSession->error("Terjadi kesalahan di sistem");
            }
        }
        $this->view->pick('index/register');
    }
}
