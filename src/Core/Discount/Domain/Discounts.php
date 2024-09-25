<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain;

use Teamleader\Discounts\Shared\Domain\CollectionBase;

final class Discounts extends CollectionBase
{
    public function __construct(Discount ...$discounts)
    {
        parent::__construct($discounts);
    }

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