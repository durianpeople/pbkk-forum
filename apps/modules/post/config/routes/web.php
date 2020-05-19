<?php

use Phalcon\Mvc\Router;

$mod_config = [
    'namespace' => $module['webControllerNamespace'],
    'module' => $moduleName,
];

$router->add('/post', array_merge($mod_config, [
    'controller' => 'post',
    'action' => 'index'
]));

// $router->add('/post/create', array_merge($mod_config, [
//     'controller' => 'post',
//     'action' => 'create'
// ]));

$router->add('/post/show', array_merge($mod_config, [
    'controller' => 'post',
    'action' => 'show'
]));

$router->add('/post/delete', array_merge($mod_config, [
    'controller' => 'post',
    'action' => 'delete'
]));

$router->add('/post/vote', array_merge($mod_config, [
    'controller' => 'post',
    'action' => 'vote'
]));

$router->add('/post/comment', array_merge($mod_config, [
    'controller' => 'post',
    'action' => 'comment'
]));

$router->add('/post/uncomment', array_merge($mod_config, [
    'controller' => 'post',
    'action' => 'uncomment'
]));

$router->notFound(array_merge($mod_config, [
    'controller' => 'error',
    'action' => 'route404'
]));
