<?php

namespace Module\Integration\Core\Application\Request;

class PostCreateRequest
{
    public string $forum_id;
    public string $post_author_id;
    public string $post_title;
    public string $post_content;
}
