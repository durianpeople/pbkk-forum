<?php

namespace Module\Post\Core\Application\Response\Post;

class PostListItem
{
    public string $post_id;
    public string $post_title;
    public string $post_author_id;
    public string $post_author_name;
    public string $post_created_date;
    public int $post_votes;
}
