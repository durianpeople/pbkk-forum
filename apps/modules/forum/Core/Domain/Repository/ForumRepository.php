<?php

namespace Module\Forum\Core\Domain\Repository;

use Module\Forum\Core\Domain\Interfaces\IForumRepository;

use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\ForumID;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Module\Forum\Core\Domain\Record\BansRecord;
use Module\Forum\Core\Domain\Record\ForumRecord;
use Module\Forum\Core\Domain\Record\MembersRecord;
use Module\Forum\Core\Exception\NotFoundException;
use ReflectionClass;

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

        $forum = new Forum(
            new ForumID($forum_record->id),
            $forum_record->name,
            new UserID($forum_record->admin_id)
        );

        $reflection = new ReflectionClass(Forum::class);
        $banned_members_setter = $reflection->getProperty('banned_members');

        foreach ($forum_record->banned_members as $b) {
            $banned_members_setter->setValue($forum, new UserID($b->user_id));
        }

        return $forum;
    }

    /**
     * Find forums which admin is user
     *
     * @param User $user_id
     * @return Forum[]
     */
    public function findAdminnedForums(UserID $user_id): array
    {
        /** @var ForumRecord[] */
        $forum_records = ForumRecord::find([
            'conditions' => 'admin_id = :admin_id:',
            'bind' => [
                'admin_id' => $user_id->getIdentifier()
            ]
        ]);
        $forums = [];
        foreach ($forum_records as $r) {
            $forums[] = $this->find(new ForumID($r->id));
        }
        return $forums;
    }

    /**
     * Find joined forums
     *
     * @param User $user_id
     * @return Forum[]
     */
    public function findJoinedForums(UserID $user_id): array
    {
        /** @var MembersRecord[] */
        $members_records = MembersRecord::find([
            'conditions' => 'user_id = :user_id:',
            'bind' => [
                'user_id' => $user_id->getIdentifier()
            ]
        ]);

        /** @var Forum[] */
        $forums = [];
        foreach ($members_records as $mr) {
            $forums[] = $this->find(new ForumID($mr->forum->id));
        }
        return $forums;
    }

    public function persist(Forum $forum): bool
    {
        /** @var ForumRecord */
        $forum_record = new ForumRecord();
        $forum_record->id = $forum->id->getIdentifier();
        $forum_record->name = $forum->name;
        $forum_record->admin_id = $forum->admin_id;
        if ($forum_record->save()) {
            $reflection = new ReflectionClass(Forum::class);
            /** @var UserID[] */
            $removed_members = $reflection->getProperty('__removed_members')->getValue($forum);
            foreach ($removed_members as $m) {
                $r = MembersRecord::findFirst([
                    'conditions' => 'user_id = :user_id: AND forum_id = :forum_id:',
                    'bind' => [
                        'user_id' => $m->getIdentifier(),
                        'forum_id' => $forum->id->getIdentifier()
                    ]
                ]);
                if ($r !== null) {
                    $r->delete();
                }
            }

            /** @var UserID[] */
            $added_members = $reflection->getProperty('__added_members')->getValue($forum);
            foreach ($added_members as $m) {
                $r = new MembersRecord;
                $r->user_id = $m->getIdentifier();
                $r->forum_id = $forum->id->getIdentifier();
                $r->save();
            }

            /** @var UserID[] */
            $new_banned_members = $reflection->getProperty('banned_members')->getValue($forum);
            foreach ($new_banned_members as $m) {
                $r = new BansRecord();
                $r->user_id = $m->getIdentifier();
                $r->forum_id = $forum->id->getIdentifier();
                $r->save();
            }
        }
        return false;
    }
}
