<?php

namespace Common\Interfaces;

interface EqualityComparable
{
    public function equals($other_object): bool;
}