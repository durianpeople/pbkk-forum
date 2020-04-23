<?php

namespace Module\Forum\Core\Application\Request\Forum;

class BanMemberRequest
{
    public string $user_id;
    public string $forum_id;
}