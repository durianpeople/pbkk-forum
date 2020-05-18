<?php

namespace Module\Post\Core\Exception;

use Exception;

class NotFoundException extends Exception
{
    public function __construct(string $e)
    {
        parent::__construct($e);
    }
}
