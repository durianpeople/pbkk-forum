<?php

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
$di->set('userRepository', function () {
    return new UserRepository();
});

$di->set('forumRepository', function () {
    return new ForumRepository();
});
#endregion


#region Services
$di->set('authService', function () use ($di) {
    return new AuthService($di->get('userRepository'));
});

$di->set('awardService', function () use ($di) {
    return new AwardService($di->get('userRepository'));
});

$di->set('registrationService', function () use ($di) {
    return new RegistrationService($di->get('userRepository'));
});

$di->set('userEditService', function () use ($di) {
    return new UserEditService($di->get('userRepository'));
});

$di->set('banMemberService', function () use ($di) {
    return new BanMemberService($di->get('forumRepository'), $di->get('userRepository'));
});

$di->set('createForumService', function () use ($di) {
    return new CreateForumService($di->get('forumRepository'), $di->get('userRepository'));
});

$di->set('joinForumService', function () use ($di) {
    return new JoinForumService($di->get('forumRepository'), $di->get('userRepository'));
});

$di->set('leaveForumService', function () use ($di) {
    return new LeaveForumService($di->get('forumRepository'), $di->get('userRepository'));
});

$di->set('listForumService', function () use ($di) {
    return new ListForumService($di->get('forumRepository'));
});

$di->set('viewForumService', function () use ($di) {
    return new ViewForumService($di->get('forumRepository'), $di->get('userRepository'));
});

#endregion