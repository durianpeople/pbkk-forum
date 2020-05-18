<?php

namespace Common\Structure;

use Common\Interfaces\EqualityComparable;

/**
 * Watchable list. This list can track added and removed items.
 * 
 * Items contained in this list must implement EqualityComparable.
 * 
 * This list cannot contain duplicate items.
 */
class WatchableList
{
    /** @var EqualityComparable[] */
    protected array $added_items = [];
    /** @var EqualityComparable[] */
    protected array $current_items = [];
    /** @var EqualityComparable[] */
    protected array $initial_items = [];
    /** @var EqualityComparable[] */
    protected array $removed_items = [];

    protected string $watched_class;

    public function __construct(string $watched_class)
    {
        $interfaces = class_implements($watched_class, true);
        assert(($interfaces && in_array(EqualityComparable::class, $interfaces)), new \TypeError("Class must be equality comparable"));

        $this->watched_class = $watched_class;
    }

    /**
     * Optional. Initialize list with items
     *
     * @param array $items
     * @return void
     */
    public function initializeItems(array $items)
    {
        if (!empty($this->initial_items)) throw new \RuntimeException("List is already initialized");

        foreach ($items as $item) {
            assert($item instanceof $this->watched_class, new \TypeError("Item must be a type of " . $this->watched_class));
        }

        $this->current_items = $items;
        $this->initial_items = $items;
    }

    /**
     * Add item to watchable list
     *
     * @param mixed $item
     * @return void
     */
    public function add($item)
    {
        $this->assertItemType($item);

        if ($this->isRemovedItem($item)) {
            $this->removeFromRemoved($item);
        }

        if (!$this->isAddedItem($item) && !$this->isInitialItem($item)) {
            $this->added_items[] = $item;
        }

        if (!$this->isCurrentItem($item)) {
            $this->current_items[] = $item;
        }
    }

    /**
     * Remove item from watchable list
     *
     * @param mixed $item
     * @return void
     */
    public function remove($item)
    {
        $this->assertItemType($item);

        $this->removeFromCurrent($item);

        if ($this->isAddedItem($item)) {
            $this->removeFromAdded($item);
        }

        if (!$this->isRemovedItem($item)) {
            $this->removed_items[] = $item;
        }
    }

    /**
     * Count items in this list
     *
     * @return integer
     */
    public function count(): int
    {
        return count($this->current_items);
    }

    public function getAddedItems(): array
    {
        return $this->added_items;
    }

    public function getRemovedItems(): array
    {
        return $this->removed_items;
    }

    public function getCurrentItems(): array
    {
        return $this->current_items;
    }

    private function assertItemType($item)
    {
        assert(($item instanceof $this->watched_class), new \TypeError("Item must be a type of " . $this->watched_class));
    }

    private function isInitialItem($item): bool
    {
        foreach ($this->initial_items as $i) {
            if ($i->equals($item)) return true;
        }
        return false;
    }

    private function isAddedItem($item): bool
    {
        foreach ($this->added_items as $i) {
            if ($i->equals($item)) return true;
        }
        return false;
    }

    private function isRemovedItem($item): bool
    {
        foreach ($this->removed_items as $i) {
            if ($i->equals($item)) return true;
        }
        return false;
    }

    private function isCurrentItem($item): bool
    {
        foreach ($this->current_items as $i) {
            if ($i->equals($item)) return true;
        }
        return false;
    }

    private function removeFromAdded($item)
    {
        foreach ($this->added_items as $key => $i) {
            if ($i->equals($item)) {
                unset($this->added_items[$key]);
                break;
            }
        }
    }

    private function removeFromRemoved($item)
    {
        foreach ($this->removed_items as $key => $i) {
            if ($i->equals($item)) {
                unset($this->removed_items[$key]);
                break;
            }
        }
        return false;
    }

    private function removeFromCurrent($item)
    {
        foreach ($this->current_items as $key => $i) {
            if ($i->equals($item)) {
                unset($this->current_items[$key]);
                break;
            }
        }
        return false;
    }
}
