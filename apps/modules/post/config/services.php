<?php

use Common\Events\DomainEventPublisher;
use Module\Post\Core\Application\EventSubscriber\PostEventSubscriber;
use Module\Post\Infrastructure\Persistence\Repository\PostRepository;
use Module\Post\Infrastructure\Persistence\Repository\UserRepository;
use Module\Post\Infrastructure\Persistence\Repository\CommentRepository;
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

$di->set('postRepository', function () {
    return new PostRepository();
});

$di->set('commentRepository', function () {
    return new CommentRepository();
});
#endregion

#region Events
DomainEventPublisher::instance()->subscribe(new PostEventSubscriber($di->get('postRepository')));
#endregion
