<?php

namespace Module\Forum\Core\Domain\Repository;

use Module\Dashboard\Core\Domain\Model\Entity\Entity;
use Module\Dashboard\Core\Domain\Model\Value\Identity;
use Phalcon\Di\Injectable;

abstract class Repository extends Injectable
{
    abstract public function find(Identity $identity): Entity;
    abstract public function persist(Entity $entity);
}