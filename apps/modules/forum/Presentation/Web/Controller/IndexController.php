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
    protected AwardService $award_service;

    public function initialize()
    {
        parent::initialize();
        $this->award_service = $this->di->get('awardService');
    }

    public function logoutAction()
    {
        $this->logout();
        $this->response->redirect("/");
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
