<?php

namespace Module\Forum\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

use Module\Forum\Core\Application\Request\User\RegistrationRequest;
use Module\Forum\Core\Application\Service\User\RegistrationService;

class RegisterController extends Controller
{
    public function indexAction()
    {
        if ($this->request->isPost()) {
            $request = new RegistrationRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');

            $registration_service = new RegistrationService();
            // $user_service->setDI($this->getDI());
            if ($registration_service->execute($request)) {
                $this->view->setVar('success', true);
                $this->response->setStatusCode(200, 'OK');
            } else {
                $this->view->setVar('success', false);
                $this->response->setStatusCode(400, 'Bad request');
            }
        } else {
            $this->view->setVar('success', false);
            $this->response->setStatusCode(400, 'Bad request');
        }
    }
}
