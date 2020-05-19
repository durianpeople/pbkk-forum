<?php

namespace Module\Integration\Presentation\Web\Controller;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->pick('index/index');
    }
}
