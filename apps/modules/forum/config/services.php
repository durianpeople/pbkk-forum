<?php

use Module\Forum\Core\Domain\Repository\UserRepository;
use Phalcon\Db\Adapter\Pdo\Mysql;
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
    return new Mysql([
        'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'dbname'   => 'pbkk_test',
    ]);
};

#region Repositories
$di['userRepository'] = function() {
    return new UserRepository();
};
#endregion
