<?php

namespace Module\Forum\Core\Application\Request\Forum;

class LeaveForumRequest
{
    public int $user_id;
    public int $forum_id;
}