<?php

namespace Module\Integration\Infrastructure\Persistence\Repository;

use Module\Integration\Core\Domain\Interfaces\IUserRepository;
use Module\Integration\Core\Domain\Model\Password;
use Module\Integration\Core\Domain\Model\User;
use Module\Integration\Core\Domain\Model\UserID;
use Module\Integration\Core\Exception\NotFoundException;
use Module\Integration\Core\Exception\WrongPasswordException;
use Module\Integration\Infrastructure\Persistence\Record\UserRecord;
use ReflectionClass;

class UserRepository implements IUserRepository
{
    private function reconstituteFromRecord(UserRecord $user_record): User
    {
        $user = new User(new UserID($user_record->id), $user_record->username, new Password($user_record->password_hash));
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

    public function persist(User $user): bool
    {
        /** @var UserRecord */
        $user_record = new UserRecord();
        $user_record->id = $user->id->getIdentifier();
        $user_record->username = $user->username;
        $user_record->password_hash = $user->password->getHash();
        $user_record->save();
        return true;
    }
}
