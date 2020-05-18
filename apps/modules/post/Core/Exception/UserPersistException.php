<?php

namespace Module\Post\Core\Exception;

use Exception;

class UserPersistException extends Exception
{
    public function __construct()
    {
        parent::__construct("User already Exists");
    }
}
