<?php

namespace Module\Forum;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([

            'Module\Forum\Core\Domain\Event' => __DIR__ . '/Core/Domain/Event',
            'Module\Forum\Core\Domain\Model\Entity' => __DIR__ . '/Core/Domain/Model/Entity',
            'Module\Forum\Core\Domain\Model\Value' => __DIR__ . '/Core/Domain/Model/Value',
            'Module\Forum\Core\Domain\Repository' => __DIR__ . '/Core/Domain/Repository',
            'Module\Forum\Core\Domain\Service' => __DIR__ . '/Core/Domain/Service',

            'Module\Forum\Core\Application\Service' => __DIR__ . '/Core/Application/Service',
            'Module\Forum\Core\Application\EventSubscriber' => __DIR__ . '/Core/Application/EventSubscriber',

            'Module\Forum\Infrastructure\Persistence' => __DIR__ . '/Core/Infrastructure/Persistence',

            'Module\Forum\Presentation\Web\Controller' => __DIR__ . '/Presentation/Web/Controller',
            'Module\Forum\Presentation\Web\Validator' => __DIR__ . '/Presentation/Web/Validator',
            'Module\Forum\Presentation\Api\Controller' => __DIR__ . '/Presentation/Api/Controller',
            
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