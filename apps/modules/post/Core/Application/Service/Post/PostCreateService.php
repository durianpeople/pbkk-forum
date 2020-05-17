<?php

namespace Module\Post\Core\Application\Service\Post;

use Module\Post\Core\Application\Request\Post\PostCreateRequest;
use Module\Post\Core\Domain\Interfaces\IPostRepository;
use Module\Post\Core\Domain\Interfaces\IUserRepository;
use Module\Post\Core\Domain\Model\Value\PostID;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Core\Domain\Model\Entity\Post;
use Phalcon\Di\Injectable;

class PostCreateService extends Injectable
{
    public function execute(PostCreateRequest $request): bool
    {
        $post_repo = $this->di->get('postRepository');
        $post = Post::create($request->post_title, $request->post_content, new UserID($request->post_author_id));
        
        return $post_repo->persist($post); 
    }
}
