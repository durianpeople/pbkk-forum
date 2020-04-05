<?php

namespace Module\Forum\Core\Domain\Repository;

use Module\Forum\Core\Domain\Model\Entity\User;
use Module\Forum\Core\Domain\Model\Value\Password;
use Module\Forum\Core\Domain\Model\Value\ID;
use Module\Forum\Core\Domain\Record\UserRecord;
use Module\Forum\Core\Exception\NotFoundException;

class UserRepository
{
    public function find(ID $user_id): User
    {
        /** @var UserRecord */
        $user_record = UserRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $user_id->getIdentifier()
            ]
        ]);
        if (!$user_record) throw new NotFoundException;
        return new User(new ID($user_record->id), $user_record->username, new Password($user_record->password_hash));
    }

    public function findByUserPass(string $username, Password $password): User
    {
        /** @var UserRecord */
        $user_record = UserRecord::findFirst([
            'conditions' => 'username = :username: AND password_hash = :password_hash:',
            'bind' => [
                'username' => $username,
                'password_hash' => $password->getHash()
            ]
        ]);
        if (!$user_record) throw new NotFoundException;
        return new User(new ID($user_record->id), $user_record->username, new Password($user_record->password_hash));
    }

    public function persist(User $user)
    {
        $user_record = new UserRecord();
        $user_record->username = $user->username;
        $user_record->password_hash = $user->password->getHash();
        return $user_record->save();
    }
}
