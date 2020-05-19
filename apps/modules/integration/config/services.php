<?php

use Module\Integration\Core\Application\Request\UserInfoRenewalRequest;
use Module\Integration\Core\Application\Service\AuthService;
use Module\Integration\Core\Application\Service\RegistrationService;
use Module\Integration\Core\Application\Service\UserEditService;
use Module\Integration\Infrastructure\Persistence\Repository\UserRepository;
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
$di->set('userRepository', function(){
    return new UserRepository;
});
#endregion


#region Services
$di->set('authService', function () use ($di) {
    return new AuthService($di->get('userRepository'));
});

$di->set('registrationService', function () use ($di) {
    return new RegistrationService($di->get('userRepository'));
});

$di->set('userEditService', function () use ($di) {
    return new UserEditService($di->get('userRepository'));
});

$di->set('userInfoRenewalService', function () use ($di) {
    return new UserInfoRenewalRequest($di->get('userRepository'));
});
#endregion
