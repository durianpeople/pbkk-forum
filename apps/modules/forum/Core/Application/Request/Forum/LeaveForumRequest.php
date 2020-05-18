<?php

namespace Module\Forum\Core\Application\Request\Forum;

class LeaveForumRequest
{
    public string $user_id;
    public string $forum_id;
    public bool $leave_and_delete = false;
}