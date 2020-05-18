<?php

namespace Module\Forum\Core\Exception;

use AssertionError;

class UsernameAssertionError extends AssertionError
{
    public function __construct()
    {
        parent::__construct();
    }
}
