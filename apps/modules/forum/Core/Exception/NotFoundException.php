<?php

namespace Module\Forum\Core\Exception;

use Exception;

class NotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("Object not found");
    }
}