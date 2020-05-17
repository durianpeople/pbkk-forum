<?php

namespace Module\Post\Core\Application\Service\Post;

use Module\Post\Core\Application\Request\Post\PostDeleteRequest;
use Module\Post\Core\Domain\Interfaces\IPostRepository;
use Module\Post\Core\Domain\Interfaces\IUserRepository;
use Module\Post\Core\Domain\Model\Value\PostID;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Core\Domain\Model\Entity\Post;
use Phalcon\Di\Injectable;

class PostDeleteService extends Injectable
{
    public function execute(PostDeleteRequest $request): bool
    {
        $post_repo = $this->di->get('postRepository');
        $post_id = new PostID($request->post_id);
        $user_id = new UserID($request->post_author_id);
        if ($post_repo->isAuthorizedPost($post_id, $user_id)) {
          $post = $post_repo->findByID($post_id);
          $post->will_be_deleted = true;        
          return $post_repo->persist($post); 
        } else return false;
    }
}
