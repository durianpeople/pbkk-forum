<?php

namespace Module\Forum\Core\Domain\Interfaces;

interface IRepository
{
    public function find(IIdentity $identity): IEntity;
    public function persist(IEntity $entity): bool;
}
