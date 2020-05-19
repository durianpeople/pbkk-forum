<?php

use Phalcon\Mvc\Router;

$mod_config = [
    'namespace' => $module['webControllerNamespace'],
    'module' => $moduleName,
];

/** @var Router $router */

$router->add('/award', array_merge($mod_config, [
    'controller' => 'index',
    'action' => 'award'
]));

$router->add('/forum', array_merge($mod_config, [
    'controller' => 'forum',
    'action' => 'index'
]));

$router->add('/forum/create', array_merge($mod_config, [
    'controller' => 'forum',
    'action' => 'create'
]));

$router->add('/forum/view', array_merge($mod_config, [
    'controller' => 'forum',
    'action' => 'view'
]));

$router->add('/forum/join', array_merge($mod_config, [
    'controller' => 'forum',
    'action' => 'join'
]));

$router->add('/forum/leave', array_merge($mod_config, [
    'controller' => 'forum',
    'action' => 'leave'
]));

$router->add('/forum/ban', array_merge($mod_config, [
    'controller' => 'forum',
    'action' => 'ban'
]));
