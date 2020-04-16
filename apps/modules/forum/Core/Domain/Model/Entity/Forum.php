<?php

namespace Module\Forum\Core\Domain\Model\Entity;

use Module\Forum\Core\Domain\Model\Value\ForumID;
use Module\Forum\Core\Domain\Model\Value\UserID;

/**
 * @property-read ForumID $id
 * @property-read string $name
 * @property-read UserID $admin_id
 */
class Forum
{
    protected ForumID $id;
    protected string $name;
    protected UserID $admin_id;
    /** @var UserID[] */
    protected array $banned_members; // retrieved by repository
    
    /** @var UserID[] */
    protected array $__added_members; // temporary, persisted to repository
    /** @var UserID[] */
    protected array $__removed_members; // temporary, persisted to repository
    /** @var UserID[] */
    protected array $__new_banned_members; // temporary, persisted to repository

    public static function create(string $name, UserID $admin_id): Forum
    {
        return new Forum(ForumID::generate(), $name, $admin_id);
    }

    public function __construct(ForumID $id, string $name, UserID $admin_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->admin_id = $admin_id;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'id':
                return $this->id;
            case 'name':
                return $this->name;
            case 'admin_id':
                return $this->admin_id;
        }
    }

    public function addMember(User $member): bool
    {
        if ($member->id === null) return false;
        if (array_search($member->id, $this->__added_members) === true) return false;
        if (array_search($member->id, $this->banned_members) === true) return false;

        $this->__added_members[] = $member->id;
        return true;
    }

    public function removeMember(User $member): bool
    {
        if ($member->id === null) return false;
        if (array_search($member->id, $this->__removed_members) === true) return false;

        if (false !== $idx = array_search($member->id, $this->__added_members)) {
            unset($this->__added_members[$idx]);
        }

        $this->__removed_members[] = $member->id;
        return true;
    }

    public function banMember(User $member): bool
    {
        if ($member->id === null) return false;
        if (array_search($member->id, $this->banned_members) === true) return false;

        $this->banned_members[] = $member->id;
        $this->__new_banned_members[] = $member->id;
        return true;
    }
}
