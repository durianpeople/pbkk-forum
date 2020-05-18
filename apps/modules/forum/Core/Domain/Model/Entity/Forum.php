<?php

namespace Module\Forum\Core\Domain\Model\Entity;

use Module\Forum\Core\Domain\Model\Value\ForumID;
use Module\Forum\Core\Domain\Model\Value\UserID;
use Module\Forum\Core\Exception\AdminRemovalException;
use Module\Forum\Core\Exception\BannedMemberException;

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
    protected array $banned_members = []; // retrieved by repository

    /** @var UserID[] */
    protected array $__added_members = []; // temporary, persisted to repository
    /** @var UserID[] */
    protected array $__removed_members = []; // temporary, persisted to repository

    protected bool $__mark_for_deletion = false; // flag

    public static function create(string $name, User $admin): Forum
    {
        $forum = new Forum(ForumID::generate(), $name, $admin->id);
        $forum->addMember($admin);
        return $forum;
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
        if ($member->id === null)
            throw new \AssertionError("Argument has an ID of null");

        foreach ($this->__added_members as $i) {
            if ($member->id == $i) return true;
        }

        foreach ($this->banned_members as $i) {
            if ($member->id == $i) throw new BannedMemberException;
        }

        $this->__added_members[] = $member->id;
        return true;
    }

    public function removeMember(User $member, bool $force = false): bool
    {
        if ($member->id === null)
            throw new \AssertionError("Argument has an ID of null");

        foreach ($this->__removed_members as $i) {
            if ($member->id == $i) return true;
        }

        if ($member->id == $this->admin_id) {
            if (!$force)
                throw new AdminRemovalException;
            else
                $this->__mark_for_deletion = true;
        }

        $this->__removed_members[] = $member->id;
        return true;
    }

    public function banMember(User $member): bool
    {
        if ($member->id === null)
            throw new \AssertionError("Argument has an ID of null");

        foreach ($this->banned_members as $i) {
            if ($member->id == $i) return true;
        }

        $this->banned_members[] = $member->id;
        return true;
    }
}
