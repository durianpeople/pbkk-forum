<?php

namespace Module\Post\Presentation\Web\Controller;

use Module\Post\Core\Application\Request\User\LoginRequest;
use Module\Post\Core\Application\Request\User\RegistrationRequest;
use Phalcon\Mvc\Controller;

use Module\Post\Core\Application\Service\User\AuthService;
use Module\Post\Core\Application\Service\User\RegistrationService;
use Module\Post\Core\Exception\UserPersistException;
use Module\Post\Core\Exception\WrongLoginException;
use Module\Post\Core\Exception\NotFoundException;

class ErrorController extends Controller
{
    public function route404Action()
    {
    }
}
