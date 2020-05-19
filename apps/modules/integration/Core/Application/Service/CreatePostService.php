<?php

namespace Module\Integration\Core\Application\Service;

use Module\Integration\Core\Application\Request\PostCreateRequest;
use Module\Integration\Core\Domain\Interfaces\IPostRepository;
use Module\Integration\Core\Domain\Model\ForumID;
use Module\Integration\Core\Domain\Model\Post;
use Module\Integration\Core\Domain\Model\UserID;

class CreatePostService
{
    protected IPostRepository $post_repo;

    public function __construct(IPostRepository $post_repo)
    {
        $this->post_repo = $post_repo;
    }

    public function execute(PostCreateRequest $request): bool
    {
        $post = Post::create(
            new ForumID($request->forum_id),
            $request->post_title,
            $request->post_content,
            new UserID($request->post_author_id)
        );
        return $this->post_repo->persist($post);
    }
}
