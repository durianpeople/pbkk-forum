<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Response\UserInfo;

use Phalcon\Mvc\Controller;

class AuthenticatedBaseController extends Controller
{
    protected UserInfo $user_info;

    public function beforeExecuteRoute()
    {
        if (!$this->session->has('user_info')) {
            $this->response->redirect("/login")->send();
            return false;
        }
        return true;
    }

    public function initialize()
    {
        $this->user_info = $this->session->get('user_info');
    }

    protected function logout()
    {
        return $this->session->destroy('user_info');
    }
}
