<?php

namespace Module\Post\Core\Application\Service\Post;

use Module\Post\Core\Application\Response\Post\PostListItem;
use Module\Post\Core\Domain\Interfaces\IPostRepository;
use Module\Post\Core\Domain\Interfaces\IUserRepository;
use Module\Post\Core\Domain\Model\Value\PostID;
use Phalcon\Di\Injectable;

class PostListService extends Injectable
{
    public function execute(): array
    {
        $repo = $this->di->get('postRepository');
        $user_repo = $this->di->get('userRepository');
        $posts = $repo->all();

        $post_list = [];

        foreach ($posts as $p) {
            $item = new PostListItem();
            $item->post_id = $p->id->getID();
            $item->post_title = $p->title;
            $item->post_author_name = $user_repo->findByID($p->author_id)->username; 
            $item->post_author_id = $p->author_id->getID(); 
            $item->post_created_date = $p->created_date;
            $item->post_votes = count($p->voted_members);
            $post_list[] = $item;
        }

        return $post_list;
    }
}
