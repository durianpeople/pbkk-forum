<?php

namespace Module\Forum\Core\Domain\Repository;

use Module\Forum\Core\Domain\Model\Entity\IEntity;
use Module\Forum\Core\Domain\Model\Value\IIdentity;
use Phalcon\Di\Injectable;

abstract class AbstractRepository extends Injectable
{
    abstract public function find(IIdentity $identity): IEntity;
    abstract public function persist(IEntity $entity);
}
