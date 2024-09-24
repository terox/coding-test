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

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function isEmpty(): bool
    {
        return count($this->items) > 0;
    }

    public static function empty(): static
    {
        return new static([]);
    }
}