<?php

namespace Module\Forum\Core\Exception;

use AssertionError;

class PasswordAssertionError extends AssertionError
{
    public function __construct()
    {
        parent::__construct();
    }
}