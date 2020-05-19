<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Request\Forum\BanMemberRequest;
use Module\Forum\Core\Application\Request\Forum\CreateForumRequest;
use Module\Forum\Core\Application\Request\Forum\JoinForumRequest;
use Module\Forum\Core\Application\Request\Forum\LeaveForumRequest;
use Module\Forum\Core\Application\Request\Forum\ListForumRequest;
use Module\Forum\Core\Application\Request\Forum\ViewForumRequest;
use Module\Forum\Core\Application\Request\User\UserInfoRequest;
use Module\Forum\Core\Application\Service\Forum\BanMemberService;
use Module\Forum\Core\Application\Service\Forum\CreateForumService;
use Module\Forum\Core\Application\Service\Forum\JoinForumService;
use Module\Forum\Core\Application\Service\Forum\LeaveForumService;
use Module\Forum\Core\Application\Service\Forum\ListForumService;
use Module\Forum\Core\Application\Service\Forum\ViewForumService;
use Module\Forum\Core\Application\Service\User\UserInfoService;
use Module\Forum\Core\Exception\BannedMemberException;
use Module\Forum\Core\Exception\NotFoundException;

class ForumController extends AuthenticatedBaseController
{
    protected ListForumService $list_forum_service;
    protected CreateForumService $create_forum_service;
    protected ViewForumService $view_forum_service;
    protected JoinForumService $join_forum_service;
    protected LeaveForumService $leave_forum_service;
    protected BanMemberService $ban_member_service;
    protected UserInfoService $user_info_service;

    public function initialize()
    {
        parent::initialize();
        $this->list_forum_service = $this->di->get('listForumService');
        $this->create_forum_service = $this->di->get('createForumService');
        $this->view_forum_service = $this->di->get('viewForumService');
        $this->join_forum_service = $this->di->get('joinForumService');
        $this->leave_forum_service = $this->di->get('leaveForumService');
        $this->ban_member_service = $this->di->get('banMemberService');
        $this->user_info_service = $this->di->get('userInfoService');
    }

    public function indexAction()
    {
        $user_info_request = new UserInfoRequest;
        $user_info_request->user_id = $this->user_info->id;

        $request = new ListForumRequest;
        $request->user_id = $this->user_info->id;
        $this->view->setVar('user_info', $this->user_info_service->execute($user_info_request));
        $this->view->setVar('joined_forums', $this->list_forum_service->execute($request));
        $request->user_id = null;
        $this->view->setVar('all_forums', $this->list_forum_service->execute($request));
    }

    public function createAction()
    {
        if ($this->request->isPost()) {

            $request = new CreateForumRequest;
            $request->admin_id = $this->user_info->id;
            $request->forum_name = $this->request->getPost('forum_name', 'string');

            $this->create_forum_service->execute($request);

            $this->response->redirect("/forum");
        }
    }

    public function viewAction()
    {
        $request = new ViewForumRequest;
        $request->forum_id = $this->request->get('id', 'string');
        $request->user_id = $this->user_info->id;

        try {
            $this->view->setVar('forum', $this->view_forum_service->execute($request));
            $this->view->setVar('user', $this->user_info);
        } catch (NotFoundException $e) {
            $this->response->redirect("/forum");
        }
    }

    public function joinAction()
    {
        $request = new JoinForumRequest;
        $request->user_id = $this->user_info->id;
        $request->forum_id = $this->request->get('id', 'string');

        try {
            $this->join_forum_service->execute($request);
        } catch (BannedMemberException $e) {
            $this->flashSession->error("Anda telah diblokir dari forum");
        }
        $this->response->redirect('/forum/view?id=' . $request->forum_id);
    }

    public function leaveAction()
    {
        $request = new LeaveForumRequest;
        $request->user_id = $this->user_info->id;
        $request->forum_id = $this->request->get('id', 'string');

        $this->leave_forum_service->execute($request);
        $this->response->redirect('/forum/view?id=' . $request->forum_id);
    }

    public function banAction()
    {
        $request = new BanMemberRequest;
        $request->admin_id = $this->user_info->id;
        $request->user_id = $this->request->get('userid', 'string');
        $request->forum_id = $this->request->get('id', 'string');

        try {
            $this->ban_member_service->execute($request);
        } catch (\DomainException $e) {
            $this->flashSession->error("Anda tidak berhak melakukan ban");
        }
        $this->response->redirect('/forum/view?id=' . $request->forum_id);
    }
}
