<?php

namespace Module\Integration\Presentation\Web\Controller;

use Module\Integration\Core\Application\Request\LoginRequest;
use Module\Integration\Core\Application\Service\AuthService;
use Module\Integration\Core\Exception\NotFoundException;
use Module\Integration\Core\Exception\WrongPasswordException;
use Phalcon\Mvc\Controller;
use stdClass;

class LoginController extends Controller
{
    protected AuthService $auth_service;

    public function initialize()
    {
        $this->auth_service = $this->di->get('authService');
    }

    public function indexAction()
    {
        if ($this->request->isPost()) {
            $request = new LoginRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');

            try {
                if ($user_info = $this->auth_service->execute($request)) {
                    $ui = new stdClass;
                    $ui->id = $user_info->id;
                    $ui->username = $user_info->username;
                    $this->session->set('user_info', $ui);
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
