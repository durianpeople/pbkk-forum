<?php

use Common\Events\DomainEventPublisher;
use Module\Forum\Core\Application\Service\Forum\BanMemberService;
use Module\Forum\Core\Application\Service\Forum\CreateForumService;
use Module\Forum\Core\Application\Service\Forum\JoinForumService;
use Module\Forum\Core\Application\Service\Forum\LeaveForumService;
use Module\Forum\Core\Application\Service\Forum\ListForumService;
use Module\Forum\Core\Application\Service\Forum\ViewForumService;
use Module\Forum\Core\Application\Service\User\AuthService;
use Module\Forum\Core\Application\Service\User\AwardService;
use Module\Forum\Core\Application\Service\User\RegistrationService;
use Module\Forum\Core\Application\Service\User\UserEditService;
use Module\Forum\Core\Application\Service\User\UserInfoRenewalService;
use Module\Forum\Infrastructure\Persistence\Repository\ForumRepository;
use Module\Forum\Infrastructure\Persistence\Repository\UserRepository;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\View;

/** @var DiInterface $di */

$di->set('view', function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/../Presentation/Web/views/');

    $view->registerEngines(
        [
            ".volt" => "voltService",
        ]
    );

    return $view;
});

$di->set('db', function () {
    $adapter = getenv('DB_ADAPTER');
    return new $adapter([
        'host'     => getenv('DB_HOST'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'dbname'   => getenv('DB_NAME'),
    ]);
});

#region Repositories

#endregion


#region Services

#endregion


#region Event listeners

#endregion