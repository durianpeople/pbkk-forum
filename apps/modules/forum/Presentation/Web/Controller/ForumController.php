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
use Module\Forum\Core\Exception\NotFoundException;
use Phalcon\Mvc\Controller;

class ForumController extends Controller
{
    public function indexAction()
    {
        $auth_service = new AuthService;

        if ($auth_service->isLoggedIn() === false)
            $this->response->redirect("/login");

        $list_forum_service = new ListForumService;
        $user = $auth_service->getUser();
        $request = new ListForumRequest;
        $request->user_id = $user->id->getIdentifier();
        $this->view->setVar('joined_forums', $list_forum_service->execute($request));
        $request->user_id = null;
        $this->view->setVar('all_forums', $list_forum_service->execute($request));
    }

    public function createAction()
    {
        $auth_service = new AuthService;

        if ($auth_service->isLoggedIn() === false)
            $this->response->redirect("/login");

        if ($this->request->isPost()) {
            $user = $auth_service->getUser();

            $request = new CreateForumRequest;
            $request->admin_id = $user->id->getIdentifier();
            $request->forum_name = $this->request->getPost('forum_name', 'string');

            $service = new CreateForumService;
            $service->execute($request);

            $this->response->redirect("/forum");
        }
    }

    public function viewAction()
    {
        $auth_service = new AuthService;

        if ($auth_service->isLoggedIn() === false)
            $this->response->redirect("/login");

        $request = new ViewForumRequest;
        $request->forum_id = $this->request->get('id', 'string');

        $service = new ViewForumService;
        try {
            $this->view->setVar('forum', $service->execute($request));
        } catch (NotFoundException $e) {
            $this->response->redirect("/forum");
        }
    }

    public function joinAction()
    {
        $auth_service = new AuthService;

        if ($auth_service->isLoggedIn() === false)
            $this->response->redirect("/login");

        $request = new JoinForumRequest;
        $request->user_id = $auth_service->getUser()->id->getIdentifier();
        $request->forum_id = $this->request->get('id', 'string');

        $service = new JoinForumService;
        $service->execute($request);
        $this->response->redirect('/forum/view?id=' . $request->forum_id);
    }

    public function leaveAction()
    {
        $auth_service = new AuthService;

        if ($auth_service->isLoggedIn() === false)
            $this->response->redirect("/login");

        $request = new LeaveForumRequest;
        $request->user_id = $auth_service->getUser()->id->getIdentifier();
        $request->forum_id = $this->request->get('id', 'string');

        $service = new LeaveForumService;
        $service->execute($request);
        $this->response->redirect('/forum/view?id=' . $request->forum_id);
    }

    public function banAction()
    {
        $auth_service = new AuthService;

        if ($auth_service->isLoggedIn() === false)
            $this->response->redirect("/login");

        $request = new BanMemberRequest;
        $request->user_id = $this->request->get('userid', 'string');
        $request->forum_id = $this->request->get('id', 'string');

        $service = new BanMemberService;
        $service->execute($request);
        $this->response->redirect('/forum/view?id=' . $request->forum_id);
    }
}
