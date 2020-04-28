<?php

namespace Module\Forum\Core\Exception;

use Exception;

class BannedMemberException extends Exception
{
    public function __construct()
    {
        parent::__construct("Member is banned");
    }
}