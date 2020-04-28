<?php

namespace Module\Forum\Core\Exception;

use Exception;

class WrongPasswordException extends Exception
{
    public function __construct()
    {
        parent::__construct("Wrong password");
    }
}