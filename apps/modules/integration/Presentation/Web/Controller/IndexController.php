<?php

namespace Module\Integration\Presentation\Web\Controller;

class IndexController extends AuthenticatedBaseController
{
    public function indexAction()
    {
        $this->view->setVar('user_info', $this->user_info);
        $this->view->pick('index/index');
    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('/');
    }
}
