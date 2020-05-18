<?php

namespace Module\Post\Core\Application\Service\Post;

use Module\Post\Core\Application\Request\Post\PostVoteRequest;
use Module\Post\Core\Domain\Interfaces\IPostRepository;
use Module\Post\Core\Domain\Interfaces\IUserRepository;
use Module\Post\Core\Domain\Model\Value\PostID;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Core\Domain\Model\Entity\Post;
use Phalcon\Di\Injectable;

class PostVoteService extends Injectable
{
    public function execute(PostVoteRequest $request): bool
    {
        $post_repo = $this->di->get('postRepository');
        $post = $post_repo->findByID(new PostID($request->voted_post_id));
        if ($post->addVote(new UserID($request->voter_id))) {
            return $post_repo->persist($post);
        }
        return false;
    }
}
