<?php

namespace IntegrationHelper\IntegrationMaster\Model;

class Collection implements CollectionInterface
{
    protected array $items = [];

    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    public function addItem(ItemInterface $item): CollectionInterface
    {
        $this->items[] = $item;

        return $this;
    }

    public function getItems(): \Iterator
    {
        return new \ArrayIterator($this->items);
    }

    public function clear(): CollectionInterface
    {
        $this->items = [];

        return $this;
    }

    public function getData(): array
    {
        return $this->items;
    }

    public function isCount(): bool
    {
        return count($this->items) > 0;
    }
}
