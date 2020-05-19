<?php

namespace Module\Integration\Core\Application\Service;

use Module\Integration\Core\Application\Request\ListPostRequest;
use Module\Integration\Core\Application\Response\PostListItem;
use Module\Integration\Core\Domain\Interfaces\IPostRepository;
use Module\Integration\Core\Domain\Interfaces\IUserRepository;
use Module\Integration\Core\Domain\Model\ForumID;

class ListPostService
{
    protected IPostRepository $post_repo;
    protected IUserRepository $user_repo;

    public function __construct(IPostRepository $post_repo, IUserRepository $user_repo)
    {
        $this->post_repo = $post_repo;
        $this->user_repo = $user_repo;
    }

    /**
     * 
     *
     * @param ListPostRequest $request
     * @return PostListItem[]
     */
    public function execute(ListPostRequest $request): array
    {
        $posts = $this->post_repo->findPostsByForum(new ForumID($request->forum_id));
        /** @var PostListItem[] */
        $post_list_items = [];
        foreach ($posts as $post) {
            $user = $this->user_repo->find($post->author_id);
            $post_list_items[] = new PostListItem($post, $user->username);
        }

        return $post_list_items;
    }

    public function getForumName(string $forum_id): string
    {
        return $this->post_repo->getForumNameByForumID(new ForumID($forum_id));
    }
}
