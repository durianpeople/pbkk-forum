<?php

use Module\Post\Infrastructure\Persistence\Repository\PostRepository;
use Module\Post\Infrastructure\Persistence\Repository\UserRepository;
use Module\Post\Infrastructure\Persistence\Repository\CommentRepository;
use Phalcon\Mvc\View;

$di['view'] = function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/../Presentation/Web/views/');

    $view->registerEngines(
        [
            ".volt" => "voltService",
        ]
    );

    return $view;
};

$di['db'] = function () {
    $adapter = getenv('DB_ADAPTER');
    return new $adapter([
        'host'     => getenv('DB_HOST'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'dbname'   => getenv('DB_NAME'),
    ]);
};

#region Repositories
$di['userRepository'] = function () {
    return new UserRepository();
};

$di['postRepository'] = function () {
    return new PostRepository();
};

$di['commentRepository'] = function () {
    return new CommentRepository();
};
#endregion
