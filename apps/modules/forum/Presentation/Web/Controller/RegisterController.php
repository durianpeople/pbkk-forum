<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Request\User\RegistrationRequest;
use Module\Forum\Core\Application\Service\User\RegistrationService;

use Module\Forum\Presentation\Web\Validator\RegistrationValidation;

use Phalcon\Mvc\Controller;

class RegisterController extends Controller
{
    protected RegistrationService $registration_service;

    public function initialize()
    {
        $this->registration_service = $this->di->get('registrationService');
    }

    public function indexAction()
    {
        if ($this->request->isPost()) {
            $validator = new RegistrationValidation();
            $messages = $validator->validate($_POST);
            if (count($messages)) {
                foreach ($messages as $m) {
                    $this->flashSession->error($m);
                }
            } else {
                $request = new RegistrationRequest();
                $request->username = $this->request->getPost('username', 'string');
                $request->password = $this->request->getPost('password', 'string');

                if ($this->registration_service->execute($request)) {
                    $this->flashSession->success("Registrasi berhasil");
                    $this->response->redirect("/login");
                } else {
                    $this->flashSession->error("Terjadi kesalahan di sistem");
                }
            }
        }

        $this->view->pick('index/register');
    }
}