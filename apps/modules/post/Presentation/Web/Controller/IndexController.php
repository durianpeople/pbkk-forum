<?php

namespace Module\Post\Presentation\Web\Controller;

use Module\Post\Core\Application\Request\User\LoginRequest;
use Module\Post\Core\Application\Request\User\RegistrationRequest;
use Phalcon\Mvc\Controller;

use Module\Post\Core\Application\Service\User\AuthService;
use Module\Post\Core\Application\Service\User\RegistrationService;
use Module\Post\Core\Exception\UserPersistException;
use Module\Post\Core\Exception\WrongLoginException;
use Module\Post\Core\Exception\NotFoundException;

class IndexController extends Controller
{
    public function indexAction()
    {
        $auth_service = new AuthService;

        if (!$auth_service->isLoggedIn()) {
            $this->view->setVar('loggedin', false);
        } else {
            try {
                $user_info = $auth_service->getUserInfo();
                $this->view->setVar('loggedin', true);
                $this->view->setVar('user_info', $user_info);
            } catch (NotFoundException $e) {
                $this->flashSession->error($e->getMessage());
                $auth_service->logout();
                $this->response->redirect("/");
            }
        }
    }

    public function loginAction()
    {
        $auth_service = new AuthService;
        if ($auth_service->isLoggedIn())
            return $this->response->redirect("/");

        if ($this->request->isPost()) {
            $this->view->disable();
            $request = new LoginRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');
            try {
                if ($auth_service->execute($request)) {
                    $this->response->redirect('/');
                }
            } catch (WrongLoginException $e) {
              $this->flashSession->error($e->getMessage());
              $this->response->redirect('/login');
            } catch (NotFoundException $e) {
              $this->flashSession->error($e->getMessage());
              $this->response->redirect('/login');
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
        $auth_service = new AuthService;
        if ($auth_service->isLoggedIn())
            return $this->response->redirect("/");

        if ($this->request->isPost()) {
            $request = new RegistrationRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');
            $registration_service = new RegistrationService();
            try {
              if ($registration_service->execute($request)) {
                $this->flashSession->success('User Created Successfully');
                $this->response->setStatusCode(200, 'OK');
              } else {
                $this->flashSession->error('Failed to create User');
                $this->response->setStatusCode(400, 'Bad request');
              }
            } catch (UserPersistException $e) {
              $this->flashSession->error($e->getMessage());
            }
            $this->response->redirect('/register');
        }
    }
}
