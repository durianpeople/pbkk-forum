<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Request\User\AwardRequest;
use Module\Forum\Core\Application\Request\User\UserEditRequest;

use Module\Forum\Core\Application\Service\User\AwardService;
use Module\Forum\Core\Application\Service\User\UserEditService;
use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Exception\DuplicateAwardException;
use Module\Forum\Core\Exception\WrongPasswordException;

class IndexController extends AuthenticatedBaseController
{
    protected IUserRepository $user_repo;

    public function initialize()
    {
        parent::initialize();
        $this->user_repo = $this->getDI()->get('userRepository');
    }

    public function indexAction()
    {
        $this->view->setVar('loggedin', true);
        $this->view->setVar('user_info', $this->user_info);
    }

    public function logoutAction()
    {
        $this->logout();
        $this->response->redirect("/");
    }

    public function editAction()
    {
        if ($this->request->isPost()) {
            $request = new UserEditRequest;
            $request->user_id = $this->user_info->id;
            if (!empty($username = $this->request->getPost('username', 'string'))) {
                $request->username = $username;
            }
            if (!empty($old_password = $this->request->getPost('old_password', 'string'))) {
                $request->old_password = $old_password;
                $request->new_password = $this->request->getPost('new_password', 'string');
            }

            $service = new UserEditService($this->user_repo);
            try {
                $service->execute($request);
                $this->flashSession->success("Profil berhasil diedit");
            } catch (\AssertionError $e) {
                $this->flashSession->error("Username should be alphanumeric");
            } catch (WrongPasswordException $e) {
                $this->flashSession->error("Pasword salah");
            }
        }
    }

    public function awardAction()
    {
        $request = new AwardRequest;
        $request->awarder_id = $this->user_info->id;
        $request->awardee_id = $this->request->get('id', 'string');

        $service = new AwardService($this->user_repo);
        try {
            $service->execute($request);
            $this->flashSession->success("Award berhasil diberikan");
        } catch (DuplicateAwardException $e) {
            $this->flashSession->error("Award hanya dapat diberikan sekali");
        }
        $this->response->redirect($_SERVER['HTTP_REFERER']);
    }
}
