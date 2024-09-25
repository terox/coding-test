<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain;

use Traversable;

abstract class CollectionBase implements Collection, \IteratorAggregate
{
    public function __construct(
        protected readonly array $items = []
    ) {
    }

    public static function empty(): static
    {
        return new static();
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function getOneOrNull(int $index): mixed
    {
        return $this->items[$index] ?? null;
    }

    public function isEmpty(): bool
    {
        return 0 === count($this->items);
    }

    public function toArray(): array
    {
        return $this->items;
    }
}