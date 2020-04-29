<?php

namespace Module\Forum\Presentation\Web\Controller;

use Module\Forum\Core\Application\Response\UserInfo;
use Phalcon\Mvc\Controller;

class AuthenticatedBaseController extends Controller
{
    protected UserInfo $user_info;

    public function initialize()
    {
        if (!$this->session->has('user_info')) {
            $this->response->redirect("/login")->send();
        } else {
            $this->user_info = $this->session->get('user_info');
        }
    }

    protected function logout()
    {
        return $this->session->destroy('user_info');
    }
}