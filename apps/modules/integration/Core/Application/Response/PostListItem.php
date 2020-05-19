<?php

namespace Module\Integration\Core\Application\Response;

use Module\Integration\Core\Domain\Model\Post;

class PostListItem
{
    public string $post_id;
    public string $post_title;
    public string $post_author_id;
    public string $post_author_name;
    public string $post_created_date;
    public int $post_votes;

    public function __construct(Post $post, string $author_name)
    {
        $this->post_id = $post->id->getID();
        $this->post_title = $post->title;
        $this->post_author_id = $post->author_id->getIdentifier();
        $this->post_author_name = $author_name;
        $this->post_created_date = $post->created_date->format('F j, Y, g:i a');
        $this->post_votes = $post->votes_count;
    }
}
