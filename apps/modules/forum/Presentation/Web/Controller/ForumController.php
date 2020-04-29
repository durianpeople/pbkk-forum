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
use Module\Forum\Core\Application\Service\User\AuthService;
use Module\Forum\Core\Exception\BannedMemberException;
use Module\Forum\Core\Exception\NotFoundException;
use Phalcon\Mvc\Controller;

class ForumController extends Controller
{
    public function indexAction()
    {
        $auth_service = new AuthService($this->getDI()->get('userRepository'));

        if ($this->session->has('user_info') === false)
            $this->response->redirect("/login");

        $list_forum_service = new ListForumService($this->getDI()->get('forumRepository'));
        $request = new ListForumRequest;
        $request->user_id = $this->session->get('user_info')->id;
        $this->view->setVar('joined_forums', $list_forum_service->execute($request));
        $request->user_id = null;
        $this->view->setVar('all_forums', $list_forum_service->execute($request));
    }

    public function createAction()
    {
        $auth_service = new AuthService($this->getDI()->get('userRepository'));

        if ($this->session->has('user_info') === false)
            $this->response->redirect("/login");

        if ($this->request->isPost()) {

            $request = new CreateForumRequest;
            $request->admin_id = $this->session->get('user_info')->id;
            $request->forum_name = $this->request->getPost('forum_name', 'string');

            $service = new CreateForumService($this->getDI()->get('forumRepository'), $this->getDI()->get('userRepository'));
            $service->execute($request);

            $this->response->redirect("/forum");
        }
    }

    public function viewAction()
    {
        $auth_service = new AuthService($this->getDI()->get('userRepository'));

        if ($this->session->has('user_info') === false)
            $this->response->redirect("/login");

        $request = new ViewForumRequest;
        $request->forum_id = $this->request->get('id', 'string');
        $request->user_id = $this->session->get('user_info')->id;

        $service = new ViewForumService($this->getDI()->get('forumRepository'), $this->getDI()->get('userRepository'));
        try {
            $this->view->setVar('forum', $service->execute($request));
            $this->view->setVar('user', $this->session->get('user_info'));
        } catch (NotFoundException $e) {
            $this->response->redirect("/forum");
        }
    }

    public function joinAction()
    {
        $auth_service = new AuthService($this->getDI()->get('userRepository'));

        if ($this->session->has('user_info') === false)
            $this->response->redirect("/login");

        $request = new JoinForumRequest;
        $request->user_id = $this->session->get('user_info')->id;
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
        $auth_service = new AuthService($this->getDI()->get('userRepository'));

        if ($this->session->has('user_info') === false)
            $this->response->redirect("/login");

        $request = new LeaveForumRequest;
        $request->user_id = $this->session->get('user_info')->id;
        $request->forum_id = $this->request->get('id', 'string');

        $service = new LeaveForumService($this->getDI()->get('forumRepository'), $this->getDI()->get('userRepository'));
        $service->execute($request);
        $this->response->redirect('/forum/view?id=' . $request->forum_id);
    }

    public function banAction()
    {
        $auth_service = new AuthService($this->getDI()->get('userRepository'));

        if ($this->session->has('user_info') === false)
            $this->response->redirect("/login");

        $request = new BanMemberRequest;
        $request->admin_id = $this->session->get('user_info')->id;
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
