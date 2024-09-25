<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain;

use Teamleader\Discounts\Shared\Domain\CollectionBase;

/**
 * @method iterable<DiscountResult> getIterator()
 * @method DiscountResult|null getOneOrNull()
 * @method DiscountResult[] toArray()
 */
final class DiscountResults extends CollectionBase
{
    public function __construct(DiscountResult ...$items)
    {
        parent::__construct($items);
    }

    public function isApplied(): bool
    {
        foreach($this->toArray() as $item) {
            if($item->isApplied()) {
                return true;
            }
        }

        return false;
    }
}