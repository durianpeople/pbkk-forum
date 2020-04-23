<?php

namespace Module\Forum\Core\Exception;

use Exception;

class DuplicateAwardException extends Exception
{
    public function __construct()
    {
        parent::__construct("Award cannot be given twice by the same user");
    }
}