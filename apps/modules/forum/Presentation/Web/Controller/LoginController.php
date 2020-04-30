<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Request\User\LoginRequest;
use Module\Forum\Core\Application\Service\User\AuthService;

use Module\Forum\Core\Exception\NotFoundException;
use Module\Forum\Core\Exception\WrongPasswordException;

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    protected AuthService $auth_service;

    public function initialize()
    {
        $this->auth_service = $this->di->get('authService');
    }

    public function indexAction()
    {
        if ($this->session->has('user_info'))
            $this->response->redirect("/");

        if ($this->request->isPost()) {
            $request = new LoginRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');

            try {
                if ($user_info = $this->auth_service->execute($request)) {
                    $this->session->set('user_info', $user_info);
                    $this->response->redirect('/');
                }
            } catch (NotFoundException $e) {
                $this->flashSession->error('Akun tidak ditemukan');
            } catch (WrongPasswordException $e) {
                $this->flashSession->error('Password salah');
            }
        }

        $this->view->pick('index/login');
    }
}