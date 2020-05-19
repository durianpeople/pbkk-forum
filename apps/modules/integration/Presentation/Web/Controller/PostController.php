<?php

namespace Module\Integration\Presentation\Web\Controller;

use Module\Integration\Core\Application\Request\ListPostRequest;
use Module\Integration\Core\Application\Request\PostCreateRequest;
use Module\Integration\Core\Application\Service\CreatePostService;
use Module\Integration\Core\Application\Service\ListPostService;

class PostController extends AuthenticatedBaseController
{
    protected ListPostService $list_service;
    protected CreatePostService $create_service;

    public function initialize()
    {
        $this->list_service = $this->di->get('listPostService');
        $this->create_service = $this->di->get('createPostService');
    }

    public function indexAction()
    {
        parent::initialize();

        $request = new ListPostRequest;
        $request->forum_id = $this->request->get('id', 'string');
        $post_list_items = $this->list_service->execute($request);

        $this->view->setVar('user_info', $this->user_info);
        $this->view->setVar('forum_name', $this->list_service->getForumName($request->forum_id));
        $this->view->setVar('posts', $post_list_items);
    }

    public function createAction()
    {
        parent::initialize();
        if ($this->request->isPost()) {
            $request = new PostCreateRequest;
            $request->forum_id = $this->request->get('forum_id', 'string');
            $request->post_author_id = $this->user_info->id;
            $request->post_title = $this->request->getPost('post_title', 'string');
            $request->post_content = $this->request->getPost('post_content', 'string');

            $this->create_service->execute($request);
            $this->flashSession->success('Post Created');
            $this->response->redirect('/forum_posts?id='.$this->request->get('forum_id', 'string'));
        }
        $this->view->setVar('user_info', $this->user_info);
    }
}
