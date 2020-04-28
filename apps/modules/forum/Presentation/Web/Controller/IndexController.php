<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Request\User\AwardRequest;
use Module\Forum\Core\Application\Request\User\LoginRequest;
use Module\Forum\Core\Application\Request\User\RegistrationRequest;
use Module\Forum\Core\Application\Request\User\UserEditRequest;
use Phalcon\Mvc\Controller;

use Module\Forum\Core\Application\Service\User\AuthService;
use Module\Forum\Core\Application\Service\User\AwardService;
use Module\Forum\Core\Application\Service\User\RegistrationService;
use Module\Forum\Core\Application\Service\User\UserEditService;
use Module\Forum\Core\Exception\DuplicateAwardException;
use Module\Forum\Core\Exception\NotFoundException;
use Module\Forum\Core\Exception\WrongPasswordException;
use Module\Forum\Presentation\Web\Validator\RegistrationValidation;

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
                $auth_service->logout();
                $this->response->redirect("/");
            }
        }
    }

    public function loginAction()
    {
        $auth_service = new AuthService;
        if ($auth_service->isLoggedIn())
            $this->response->redirect("/");

        if ($this->request->isPost()) {
            $request = new LoginRequest();
            $request->username = $this->request->getPost('username', 'string');
            $request->password = $this->request->getPost('password', 'string');

            try {
                if ($auth_service->execute($request)) {
                    $this->response->redirect('/');
                }
            } catch (NotFoundException $e) {
                $this->flashSession->error('Akun tidak ditemukan');
            } catch (WrongPasswordException $e) {
                $this->flashSession->error('Password salah');
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

                $registration_service = new RegistrationService();
                if ($registration_service->execute($request)) {
                    $this->flashSession->success("Registrasi berhasil");
                    $this->response->redirect("/login");
                } else {
                    $this->flashSession->error("Terjadi kesalahan di sistem");
                }
            }
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
            try {
                $service->execute($request);
                $this->flashSession->success("Profil berhasil diedit");
            } catch (\AssertionError $e) {
                $this->flashSession->error("Username should be alphanumeric");
            }
        }
    }

    public function awardAction()
    {
        $auth_service = new AuthService;
        if (!$auth_service->isLoggedIn())
            $this->response->redirect("/");

        $request = new AwardRequest;
        $request->awarder_id = $auth_service->getUser()->id->getIdentifier();
        $request->awardee_id = $this->request->get('id', 'string');

        $service = new AwardService;
        try {
            $service->execute($request);
            $this->flashSession->success("Award berhasil diberikan");
        } catch (DuplicateAwardException $e) {
            $this->flashSession->error("Award hanya dapat diberikan sekali");
        }
        $this->response->redirect($_SERVER['HTTP_REFERER']);
    }
}
