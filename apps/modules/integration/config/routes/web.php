<?php

use Phalcon\Mvc\Router;

$mod_config = [
    'namespace' => $module['webControllerNamespace'],
    'module' => $moduleName,
];

/** @var Router $router */

$router->add('/', array_merge($mod_config, [
    'controller' => 'index',
    'action' => 'index'
]));

$router->add('/login', array_merge($mod_config, [
    'controller' => 'login',
    'action' => 'index'
]));

$router->add('/logout', array_merge($mod_config, [
    'controller' => 'index',
    'action' => 'logout'
]));

$router->add('/register', array_merge($mod_config, [
    'controller' => 'register',
    'action' => 'index'
]));
