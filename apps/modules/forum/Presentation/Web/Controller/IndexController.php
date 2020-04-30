<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Request\User\AwardRequest;
use Module\Forum\Core\Application\Request\User\UserEditRequest;
use Module\Forum\Core\Application\Request\User\UserInfoRenewalRequest;
use Module\Forum\Core\Application\Service\User\AwardService;
use Module\Forum\Core\Application\Service\User\UserEditService;
use Module\Forum\Core\Application\Service\User\UserInfoRenewalService;
use Module\Forum\Core\Exception\DuplicateAwardException;
use Module\Forum\Core\Exception\PasswordAssertionError;
use Module\Forum\Core\Exception\UsernameAssertionError;
use Module\Forum\Core\Exception\WrongPasswordException;

class IndexController extends AuthenticatedBaseController
{
    protected UserEditService $user_edit_service;
    protected AwardService $award_service;
    protected UserInfoRenewalService $user_info_renewal_service;

    public function initialize()
    {
        parent::initialize();
        $this->user_edit_service = $this->di->get('userEditService');
        $this->award_service = $this->di->get('awardService');
        $this->user_info_renewal_service = $this->di->get('userInfoRenewalService');
    }

    public function indexAction()
    {
        $this->view->setVar('loggedin', true);
        $this->view->setVar('user_info', $this->user_info_renewal_service->execute(
            new UserInfoRenewalRequest($this->session->get('user_info'))
        ));
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

            try {
                $this->user_edit_service->execute($request);
                $this->flashSession->success("Profil berhasil diedit");
            } catch (UsernameAssertionError $e) {
                $this->flashSession->error("Username harus alphanumeric");
            } catch (PasswordAssertionError $e) {
                $this->flashSession->error("Password minimal 8 karakter");
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

        try {
            $this->award_service->execute($request);
            $this->flashSession->success("Award berhasil diberikan");
        } catch (DuplicateAwardException $e) {
            $this->flashSession->error("Award hanya dapat diberikan sekali");
        }
        $this->response->redirect($_SERVER['HTTP_REFERER']);
    }
}
