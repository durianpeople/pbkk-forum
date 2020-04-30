<?php

namespace Module\Forum\Core\Application\Request\User;

use Module\Forum\Core\Application\Response\UserInfo;

class UserInfoRenewalRequest
{
    public UserInfo $user_info;
    public function __construct(UserInfo $user_info)
    {
        $this->user_info = $user_info;
    }
}