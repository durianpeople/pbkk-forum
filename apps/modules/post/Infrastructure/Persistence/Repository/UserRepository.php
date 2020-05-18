<?php

namespace Module\Post\Infrastructure\Persistence\Repository;

use Module\Post\Core\Domain\Interfaces\IUserRepository;
use Module\Post\Core\Domain\Model\Entity\User;
use Module\Post\Core\Domain\Model\Value\Password;
use Module\Post\Core\Domain\Model\Value\UserID;
use Module\Post\Infrastructure\Persistence\Record\UserRecord;

use Module\Post\Core\Exception\UserPersistException;
use Module\Post\Core\Exception\WrongLoginException;
use Module\Post\Core\Exception\NotFoundException;
use Phalcon\Mvc\Model\Transaction\Manager;
use ReflectionClass;

class UserRepository implements IUserRepository
{
    private function reconstituteFromRecord(UserRecord $user_record): User
    {
        $user = new User(new UserID($user_record->id), $user_record->username, new Password($user_record->password_hash));
        return $user;
    }

    public function findByID(UserID $user_id): User
    {
        /** @var UserRecord */
        $user_record = UserRecord::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $user_id->getID()
            ]
        ]);
        if (!$user_record) throw new NotFoundException("User not Found");
        return $this->reconstituteFromRecord($user_record);
    }

    public function findByUserPass(string $username, string $password): User
    {
        $user_record = UserRecord::findFirst([
            'conditions' => 'username = :username:',
            'bind' => [
                'username' => $username
            ]
        ]);
        if (!$user_record) throw new NotFoundException("User Not Found");

        $user = $this->reconstituteFromRecord($user_record);
        if (!$user->password->verify($password)) throw new WrongLoginException;
        return $user;
    }

    public function persist(User $user): bool
    {
        $user_record = new UserRecord();
        $user_record->id = $user->id->getID();
        $user_record->username = $user->username;
        $user_record->password_hash = $user->password->getHash();

        $trx = (new Manager())->get();

        try {
            $user_record->save();
            $trx->commit();
            return true;
        } catch (\Exception $e) {
            $trx->rollback();
            throw new UserPersistException;
        }
        return false;
    }
}
