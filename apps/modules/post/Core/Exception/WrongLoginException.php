<?php

namespace Module\Post\Core\Exception;

use Exception;

class WrongLoginException extends Exception
{
    public function __construct()
    {
        parent::__construct("Wrong Username or Password");
    }
}
