<?php

namespace Module\Integration\Core\Application\Request;

use Module\Integration\Core\Application\Response\UserInfo;

class UserInfoRenewalRequest
{
    public UserInfo $user_info;
    public function __construct(UserInfo $user_info)
    {
        $this->user_info = $user_info;
    }
}
