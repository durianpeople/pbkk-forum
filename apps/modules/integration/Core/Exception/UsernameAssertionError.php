<?php

namespace Module\Integration\Core\Exception;

use AssertionError;

class UsernameAssertionError extends AssertionError
{
    public function __construct()
    {
        parent::__construct();
    }
}
