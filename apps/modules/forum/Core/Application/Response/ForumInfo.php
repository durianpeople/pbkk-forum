<?php

namespace Module\Forum\Core\Application\Response;

class ForumInfo
{
    public string $forum_name;
    public UserInfo $admin;
    /** @var UserInfo[] */
    public array $members;
}