<?php

namespace Module\Integration\Presentation\Web\Controller;

use Module\Integration\Core\Application\Request\ListPostRequest;
use Module\Integration\Core\Application\Service\ListPostService;

class PostController extends AuthenticatedBaseController
{
    protected ListPostService $list_service;

    public function initialize() {
        $this->list_service = $this->di->get('listPostService');
    }

    public function indexAction()
    {
        parent::initialize();
        
        $request = new ListPostRequest;
        $request->forum_id = $this->request->get('id', 'string');
        $post_list_items = $this->list_service->execute($request);

        $this->view->setVar('user_info', $this->user_info);
        $this->view->setVar('posts', $post_list_items);
    }
}