<?php

namespace Module\Integration;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([

            'Module\Integration\Core\Domain\Interfaces' => __DIR__ . '/Core/Domain/Interfaces',
            'Module\Integration\Core\Domain\Event' => __DIR__ . '/Core/Domain/Event',
            'Module\Integration\Core\Domain\Model' => __DIR__ . '/Core/Domain/Model',
            'Module\Integration\Core\Domain\Service' => __DIR__ . '/Core/Domain/Service',

            'Module\Integration\Core\Application\Request' => __DIR__ . '/Core/Application/Request',
            'Module\Integration\Core\Application\Response' => __DIR__ . '/Core/Application/Response',
            'Module\Integration\Core\Application\Interfaces' => __DIR__ . '/Core/Application/Interfaces',
            'Module\Integration\Core\Application\Service' => __DIR__ . '/Core/Application/Service',
            'Module\Integration\Core\Application\EventSubscriber' => __DIR__ . '/Core/Application/EventSubscriber',

            'Module\Integration\Core\Exception' => __DIR__ . '/Core/Exception',

            'Module\Integration\Infrastructure\Persistence\Repository' => __DIR__ . '/Infrastructure/Persistence/Repository',
            'Module\Integration\Infrastructure\Persistence\Record' => __DIR__ . '/Infrastructure/Persistence/Record',
            'Module\Post\Infrastructure\Persistence\Record' => APP_PATH . '/modules/post/Infrastructure/Persistence/Record',

            'Module\Integration\Presentation\Web\Controller' => __DIR__ . '/Presentation/Web/Controller',
            'Module\Integration\Presentation\Web\Validator' => __DIR__ . '/Presentation/Web/Validator',
            'Module\Integration\Presentation\Api\Controller' => __DIR__ . '/Presentation/Api/Controller',

        ]);

        $loader->register();
    }

    public function registerServices(DiInterface $di = null)
    {
        // Load configs
        $moduleConfig = require __DIR__ . '/config/config.php';

        $di->get('config')->merge($moduleConfig);

        // Register services/dependencies
        include_once __DIR__ . '/config/services.php';

        // Run necessary scripts
        include_once __DIR__ . '/config/bootstrap.php';
    }
}
