<?php

namespace Module\Forum\Core\Domain\Repository;

use Module\Forum\Core\Domain\Interfaces\IForumRepository;

use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Value\ForumID;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Module\Forum\Core\Domain\Record\ForumRecord;

use Module\Forum\Core\Exception\NotFoundException;

class ForumRepository implements IForumRepository
{
    public function find(ForumID $forum_id): Forum
    {
        /** @var ForumRecord */
        $forum_record = ForumRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $forum_id->getIdentifier()
            ]
        ]);
        if (!$forum_record) throw new NotFoundException;
        return new Forum(new ForumID($forum_record->id), $forum_record->name, new UserID($forum_record->admin_id));
    }

    public function persist(Forum $forum): bool
    {
        /** @var ForumRecord */
        $forum_record = ForumRecord::findFirst([
            'conditions'=> 'id = :id:',
            'bind' => [
                'id' => $forum->id->getIdentifier()
            ]
        ]);
        if ($forum_record === null) {
            $forum_record = new ForumRecord();
            $forum_record->id = $forum->id->getIdentifier();
        }
        $forum_record->name = $forum->name;
        $forum_record->admin_id = $forum->admin_id;
        if ($forum_record->save())
        {
            // persistency events
        }
        return false;
    }
}
