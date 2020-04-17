<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Request\User\LoginRequest;
use Module\Forum\Core\Application\Request\User\RegistrationRequest;
use Module\Forum\Core\Application\Request\User\UserEditRequest;
use Phalcon\Mvc\Controller;

use Module\Forum\Core\Application\Service\User\AuthService;
use Module\Forum\Core\Application\Service\User\RegistrationService;
use Module\Forum\Core\Application\Service\User\UserEditService;

class IndexController extends Controller
{
    public function indexAction()
    {
        $auth_service = new AuthService;

        if (!$auth_service->isLoggedIn()) {
            $this->view->setVar('loggedin', false);
        } else {
            $user_info = $auth_service->getUserInfo();
            $this->view->setVar('loggedin', true);
            $this->view->setVar('user_info', $user_info);
        }
    }

    public function loginAction()
    {
        $auth_service = new AuthService;
        if ($auth_service->isLoggedIn())
            $this->response->redirect("/");

        if ($this->request->isPost()) {
            $this->view->disable();
            $request = new LoginRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');

            if ($auth_service->execute($request)) {
                $this->response->redirect('/');
            }
        }
    }

    public function logoutAction()
    {
        $auth_service = new AuthService;
        if ($auth_service->logout()) {
            $this->response->redirect("/");
        }
    }

    public function registerAction()
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

    public function editAction()
    {
        $auth_service = new AuthService;
        if (!$auth_service->isLoggedIn())
            $this->response->redirect("/");

        if ($this->request->isPost()) {
            $request = new UserEditRequest;
            $request->user_id = $auth_service->getUser()->id->getIdentifier();
            if (!empty($username = $this->request->getPost('username', 'string'))) {
                $request->username = $username;
            }
            if (!empty($old_password = $this->request->getPost('old_password', 'string'))) {
                $request->old_password = $old_password;
                $request->new_password = $this->request->getPost('new_password', 'string');
            }

            $service = new UserEditService;
            $service->execute($request);
            $this->response->redirect("/");
        }
    }
}
