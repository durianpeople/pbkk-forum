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
use Phalcon\Mvc\Model\Transaction\Manager;
use ReflectionClass;

class ForumRepository implements IForumRepository
{
    private function reconstituteFromRecord(ForumRecord $forum_record): Forum
    {
        $forum = new Forum(
            new ForumID($forum_record->id),
            $forum_record->name,
            new UserID($forum_record->admin_id)
        );

        $reflection = new ReflectionClass(Forum::class);
        $banned_members_setter = $reflection->getProperty('banned_members');
        $banned_members_setter->setAccessible(true);

        $bm = [];
        foreach ($forum_record->banned_members as $b) {
            $bm[] = new UserID($b->id);
        }
        
        $banned_members_setter->setValue($forum, $bm);

        return $forum;
    }

    /**
     * Get all forums
     *
     * @return Forum[]
     */
    public function all(): array
    {
        /** @var Forum[] */
        $forums = [];
        /** @var ForumRecord[] */
        $forum_records = ForumRecord::find();
        foreach ($forum_records as $forum_record) {
            $forums[] = $this->reconstituteFromRecord($forum_record);
        }
        return $forums;
    }

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

        $forum = $this->reconstituteFromRecord($forum_record);

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
        $reflection = new ReflectionClass(Forum::class);
        $delete_mark_getter = $reflection->getProperty('__mark_for_deletion');
        $delete_mark_getter->setAccessible(true);

        if ($delete_mark_getter->getValue($forum) === true) {
            return $this->delete($forum);
        }

        /** @var ForumRecord */
        $forum_record = new ForumRecord();
        $forum_record->id = $forum->id->getIdentifier();
        $forum_record->name = $forum->name;
        $forum_record->admin_id = $forum->admin_id->getIdentifier();

        $trx = (new Manager())->get();

        try {
            if ($forum_record->save()) {
                $removed_members_getter = $reflection->getProperty('__removed_members');
                $removed_members_getter->setAccessible(true);

                /** @var UserID[] */
                $removed_members = $removed_members_getter->getValue($forum);

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

                $added_members_getter = $reflection->getProperty('__added_members');
                $added_members_getter->setAccessible(true);

                /** @var UserID[] */
                $added_members = $added_members_getter->getValue($forum);

                foreach ($added_members as $m) {
                    $r = new MembersRecord;
                    $r->user_id = $m->getIdentifier();
                    $r->forum_id = $forum->id->getIdentifier();
                    $r->save();
                }

                $banned_members_getter = $reflection->getProperty('banned_members');
                $banned_members_getter->setAccessible(true);
                /** @var UserID[] */
                $banned_members = $banned_members_getter->getValue($forum);
                foreach ($banned_members as $m) {
                    $r = new BansRecord();
                    $r->user_id = $m->getIdentifier();
                    $r->forum_id = $forum->id->getIdentifier();
                    $r->save();
                }
            }

            $trx->commit();
            return true;
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }
        return false;
    }

    public function delete(Forum $forum): bool
    {
        $forum_record = new ForumRecord();
        $forum_record->id = $forum->id->getIdentifier();
        $forum_record->name = $forum->name;
        $forum_record->admin_id = $forum->admin_id->getIdentifier();

        $trx = (new Manager())->get();
        
        try {
            $mr = MembersRecord::find([
                'conditions' => 'forum_id = :forum_id:',
                'bind' => [
                    'forum_id' => $forum->id->getIdentifier()
                ]
            ]);
            $mr->delete();
            $br = BansRecord::find([
                'conditions' => 'forum_id = :forum_id:',
                'bind' => [
                    'forum_id' => $forum->id->getIdentifier()
                ]
            ]);
            $br->delete();
            $forum_record->delete();
            $trx->commit();
            return true;
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }

        return false;
    }
}
