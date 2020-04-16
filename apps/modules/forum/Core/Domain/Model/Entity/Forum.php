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
    protected array $__added_members;
    /** @var UserID[] */
    protected array $__removed_members;

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

    public function addMember(User $member)
    {
        if ($member->id !== null)
            $this->__added_members[] = $member->id;
    }

    public function removeMember(User $member)
    {
        $idx = array_search($member->id, $this->__added_members);
        if (false !== $idx) {
            unset($this->__added_members[$idx]);
        }
        $this->__removed_members[] = $member->id;
    }
}
