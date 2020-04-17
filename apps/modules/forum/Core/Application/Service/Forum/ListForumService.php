<?php

namespace Module\Forum\Core\Application\Service\Forum;

use Module\Forum\Core\Application\Request\Forum\ListForumRequest;
use Module\Forum\Core\Application\Response\ForumListItem;
use Module\Forum\Core\Domain\Interfaces\IForumRepository;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Phalcon\Di\Injectable;

class ListForumService extends Injectable
{
    /**
     * @param ListForumRequest $request
     * @return ForumListItem[]
     */
    public function execute(ListForumRequest $request): array
    {
        /** @var IForumRepository */
        $repo = $this->di->get('forumRepository');

        if ($request->user_id !== null)
            $forums = $repo->findJoinedForums(new UserID($request->user_id));
        else
            $forums = $repo->all();

        /** @var ForumListItem[] */
        $forum_list = [];

        foreach ($forums as $f) {
            $item = new ForumListItem;
            $item->forum_id = $f->id->getIdentifier();
            $item->forum_name = $f->name;
            $forum_list[] = $item;
        }

        return $forum_list;
    }
}