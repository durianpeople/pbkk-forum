<?php

namespace Module\Forum\Core\Application\Response;

class ForumInfo
{
    public string $forum_id;
    public string $forum_name;
    public UserInfo $admin;
    public bool $is_admin = false;
    public bool $joined = false;
    /** @var UserInfo[] */
    public array $members;
}