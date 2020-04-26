<?php

namespace Module\Forum\Core\Domain\Repository;

use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\Award;
use Module\Forum\Core\Domain\Model\Value\ForumID;
use Module\Forum\Core\Domain\Model\Value\Password;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Module\Forum\Core\Domain\Record\AwardRecord;
use Module\Forum\Core\Domain\Record\UserRecord;
use Module\Forum\Core\Domain\Record\MembersRecord;

use Module\Forum\Core\Exception\NotFoundException;
use Module\Forum\Core\Exception\WrongPasswordException;
use Phalcon\Mvc\Model\Transaction\Manager;
use ReflectionClass;

class UserRepository implements IUserRepository
{
    private function reconstituteFromRecord(UserRecord $user_record): User
    {
        $user = new User(new UserID($user_record->id), $user_record->username, new Password($user_record->password_hash));

        $award_records = $user_record->awards;

        $aws = [];
        foreach ($award_records as $ar) {
            $aws[] = new Award(new UserID($ar->awarder_id));
        }
        $reflection = new ReflectionClass(User::class);
        $awards_setter = $reflection->getProperty('awards');
        $awards_setter->setAccessible(true);
        $awards_setter->setValue($user, $aws);

        return $user;
    }

    public function find(UserID $user_id): User
    {
        /** @var UserRecord */
        $user_record = UserRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $user_id->getIdentifier()
            ]
        ]);
        if (!$user_record) throw new NotFoundException;
        return $this->reconstituteFromRecord($user_record);
    }

    public function findByUserPass(string $username, string $password): User
    {
        /** @var UserRecord */
        $user_record = UserRecord::findFirst([
            'conditions' => 'username = :username:',
            'bind' => [
                'username' => $username
            ]
        ]);
        if (!$user_record) throw new NotFoundException;

        $user = $this->reconstituteFromRecord($user_record);
        if (!$user->password->testAgainst($password)) throw new WrongPasswordException;
        return $user;
    }

    /**
     * Get forum members
     *
     * @param Forum $forum
     * @return User[]
     */
    public function findForumMembers(ForumID $forum_id): array
    {
        /** @var MembersRecord[] */
        $user_forum_records = MembersRecord::find([
            'conditions' => 'forum_id = :forum_id:',
            'bind' => [
                'forum_id' => $forum_id->getIdentifier()
            ]
        ]);
        $members = [];
        foreach ($user_forum_records as $record) {
            $user_record = $record->user;
            $members[] = $this->reconstituteFromRecord($user_record);
        }
        return $members;
    }

    public function persist(User $user): bool
    {
        /** @var UserRecord */
        $user_record = new UserRecord();
        $user_record->id = $user->id->getIdentifier();
        $user_record->username = $user->username;
        $user_record->password_hash = $user->password->getHash();

        $reflection = new ReflectionClass(User::class);
        $awards_getter = $reflection->getProperty('awards');
        $awards_getter->setAccessible(true);

        $trx = (new Manager())->get();

        try {
            foreach ($awards_getter->getValue($user) as $aw) {
                /** @var Award $aw */
                $ar = new AwardRecord();
                $ar->awardee_id = $user->id->getIdentifier();
                $ar->awarder_id = $aw->awarder_id->id->getIdentifier();
                $ar->save();
            }

            $user_record->save();
            $trx->commit();
            return true;
        } catch (\Exception $e) {
            $trx->rollback();
            throw $e;
        }
        return false;
    }
}
