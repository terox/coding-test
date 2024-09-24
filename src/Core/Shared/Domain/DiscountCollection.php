<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Shared\Domain;

use Teamleader\Discounts\Core\Discount\Domain\Discount;
use Teamleader\Discounts\Shared\Domain\Collection;

abstract class DiscountCollection implements Collection
{
    public function __construct(
        private readonly array $items = []
    ) {
    }

    public static function empty(): DiscountCollection
    {
        return new static([]);
    }

    public function getOneOrNull(int $index): ?Discount
    {
        return $this->items[$index] ?? null;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}