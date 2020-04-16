<?php

namespace Module\Forum\Core\Domain\Repository;

use Module\Forum\Core\Domain\Interfaces\IUserRepository;
use Module\Forum\Core\Domain\Model\Entity\Forum;
use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\Password;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Module\Forum\Core\Domain\Record\UserRecord;
use Module\Forum\Core\Domain\Record\MembersRecord;

use Module\Forum\Core\Exception\NotFoundException;

class UserRepository implements IUserRepository
{
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
        return new User(new UserID($user_record->id), $user_record->username, new Password($user_record->password_hash));
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
        $user = new User(
            new UserID($user_record->id),
            $user_record->username,
            new Password($user_record->password_hash)
        );
        if (!$user->password->testAgainst($password)) throw new \Exception("Wrong username/password");
        return $user;
    }

    /**
     * Get forum members
     *
     * @param Forum $forum
     * @return User[]
     */
    public function getForumMembers(Forum $forum): array
    {
        /** @var MembersRecord[] */
        $user_forum_records = MembersRecord::find([
            'conditions' => 'forum_id = :forum_id:',
            'bind' => [
                'forum_id' => $forum->id
            ]
        ]);
        $members = [];
        foreach ($user_forum_records as $record) {
            $user_record = $record->user;
            $members[] = new User(
                new UserID($user_record->id),
                $user_record->username,
                new Password($user_record->password_hash)
            );
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
        return $user_record->save();
    }
}
