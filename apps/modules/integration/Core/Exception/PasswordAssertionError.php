<?php

namespace Module\Integration\Core\Exception;

use AssertionError;

class PasswordAssertionError extends AssertionError
{
    public function __construct()
    {
        parent::__construct();
    }
}
