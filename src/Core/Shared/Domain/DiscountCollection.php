<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Shared\Domain;

use Teamleader\Discounts\Core\Discount\Domain\Discount;
use Teamleader\Discounts\Shared\Domain\CollectionBase;

abstract class DiscountCollection extends CollectionBase
{
    public function getOneOrNull(int $index): ?Discount
    {
        return $this->items[$index] ?? null;
    }

    /**
     * @return Discount[]
     */
    public function toArray(): array
    {
        return $this->items;
    }
}