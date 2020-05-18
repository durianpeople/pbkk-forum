<?php

namespace Module\Post\Core\Exception;

use Exception;

class DuplicateVoteException extends Exception
{
    public function __construct()
    {
        parent::__construct("Duplicate Vote");
    }
}
