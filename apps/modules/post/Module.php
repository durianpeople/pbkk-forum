<?php

namespace Module\Post;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([

            'Module\Post\Core\Domain\Event' => __DIR__ . '/Core/Domain/Event',
            'Module\Post\Core\Domain\Interfaces' => __DIR__ . '/Core/Domain/Interfaces',
            'Module\Post\Core\Domain\Model' => __DIR__ . '/Core/Domain/Model',
            'Module\Post\Core\Domain\Service' => __DIR__ . '/Core/Domain/Service',
            
            'Module\Post\Core\Application\Service' => __DIR__ . '/Core/Application/Service',
            'Module\Post\Core\Application\EventSubscriber' => __DIR__ . '/Core/Application/EventSubscriber',
            'Module\Post\Core\Application\Request' => __DIR__ . '/Core/Application/Request',
            'Module\Post\Core\Application\Response' => __DIR__ . '/Core/Application/Response',
            
            'Module\Post\Core\Exception' => __DIR__ . '/Core/Exception',
            
            'Module\Post\Infrastructure\Persistence\Record' => __DIR__ . '/Infrastructure/Persistence/Record',
            'Module\Post\Infrastructure\Persistence\Repository' => __DIR__ . '/Infrastructure/Persistence/Repository',

            'Module\Post\Presentation\Web\Controller' => __DIR__ . '/Presentation/Web/Controller',
            'Module\Post\Presentation\Web\Validator' => __DIR__ . '/Presentation/Web/Validator',
            'Module\Post\Presentation\Api\Controller' => __DIR__ . '/Presentation/Api/Controller',

        ]);

        $loader->register();
    }

    public function registerServices(DiInterface $di = null)
    {
        $moduleConfig = require __DIR__ . '/config/config.php';

        $di->get('config')->merge($moduleConfig);

        include_once __DIR__ . '/config/services.php';
    }
}
