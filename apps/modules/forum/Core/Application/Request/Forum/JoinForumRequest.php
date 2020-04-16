<?php

namespace Module\Forum\Core\Application\Request\Forum;

use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Entity\User;

class JoinForumRequest
{
    public int $user_id;
    public int $forum_id;
}