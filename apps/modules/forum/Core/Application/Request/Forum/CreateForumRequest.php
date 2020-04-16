<?php

namespace Module\Forum\Core\Application\Request\Forum;

use Module\Forum\Core\Domain\Model\Value\UserID;

class CreateForumRequest
{
    public int $admin_id;
    public string $forum_name;
}