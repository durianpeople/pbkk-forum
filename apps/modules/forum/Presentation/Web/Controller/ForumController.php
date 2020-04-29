<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Request\Forum\BanMemberRequest;
use Module\Forum\Core\Application\Request\Forum\CreateForumRequest;
use Module\Forum\Core\Application\Request\Forum\JoinForumRequest;
use Module\Forum\Core\Application\Request\Forum\LeaveForumRequest;
use Module\Forum\Core\Application\Request\Forum\ListForumRequest;
use Module\Forum\Core\Application\Request\Forum\ViewForumRequest;
use Module\Forum\Core\Application\Service\Forum\BanMemberService;
use Module\Forum\Core\Application\Service\Forum\CreateForumService;
use Module\Forum\Core\Application\Service\Forum\JoinForumService;
use Module\Forum\Core\Application\Service\Forum\LeaveForumService;
use Module\Forum\Core\Application\Service\Forum\ListForumService;
use Module\Forum\Core\Application\Service\Forum\ViewForumService;
use Module\Forum\Core\Exception\BannedMemberException;
use Module\Forum\Core\Exception\NotFoundException;

class ForumController extends AuthenticatedBaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $list_forum_service = new ListForumService($this->getDI()->get('forumRepository'));
        $request = new ListForumRequest;
        $request->user_id = $this->user_info->id;
        $this->view->setVar('joined_forums', $list_forum_service->execute($request));
        $request->user_id = null;
        $this->view->setVar('all_forums', $list_forum_service->execute($request));
    }

    public function createAction()
    {
        if ($this->request->isPost()) {

            $request = new CreateForumRequest;
            $request->admin_id = $this->user_info->id;
            $request->forum_name = $this->request->getPost('forum_name', 'string');

            $service = new CreateForumService($this->getDI()->get('forumRepository'), $this->getDI()->get('userRepository'));
            $service->execute($request);

            $this->response->redirect("/forum");
        }
    }

    public function viewAction()
    {
        $request = new ViewForumRequest;
        $request->forum_id = $this->request->get('id', 'string');
        $request->user_id = $this->user_info->id;

        $service = new ViewForumService($this->getDI()->get('forumRepository'), $this->getDI()->get('userRepository'));
        try {
            $this->view->setVar('forum', $service->execute($request));
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

        $service = new JoinForumService($this->getDI()->get('forumRepository'), $this->getDI()->get('userRepository'));
        try {
            $service->execute($request);
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

        $service = new LeaveForumService($this->getDI()->get('forumRepository'), $this->getDI()->get('userRepository'));
        $service->execute($request);
        $this->response->redirect('/forum/view?id=' . $request->forum_id);
    }

    public function banAction()
    {
        $request = new BanMemberRequest;
        $request->admin_id = $this->user_info->id;
        $request->user_id = $this->request->get('userid', 'string');
        $request->forum_id = $this->request->get('id', 'string');

        $service = new BanMemberService($this->getDI()->get('forumRepository'), $this->getDI()->get('userRepository'));
        try {
            $service->execute($request);
        } catch (\DomainException $e) {
            $this->flashSession->error("Anda tidak berhak melakukan ban");
        }
        $this->response->redirect('/forum/view?id=' . $request->forum_id);
    }
}
