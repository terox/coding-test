<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain;

use Teamleader\Discounts\Shared\Domain\CollectionBase;

/**
 * @method iterable<Discount> getIterator()
 * @method Discount|null getOneOrNull()
 */
final class Discounts extends CollectionBase
{
    public function __construct(Discount ...$discounts)
    {
        parent::__construct($discounts);
    }

    /**
     * @return Discount[]
     */
    public function toArray(): array
    {
        return $this->items;
    }
}