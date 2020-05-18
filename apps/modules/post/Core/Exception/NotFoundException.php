<?php

namespace Module\Post\Core\Exception;

use Exception;

class NotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Object not found');
    }
}
