<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain\Event;

use Teamleader\Discounts\Core\Discount\Domain\Event\DiscountApplied;
use Teamleader\Discounts\Tests\Core\Discount\Domain\DiscountIdMother;

final class DiscountAppliedMother
{
    public static function create(?int $discountId = null, ?int $orderId = null, ?float $amount = null): DiscountApplied
    {
        return new DiscountApplied(
            $discountId ?? DiscountIdMother::create()->value(),
            $orderId ?? random_int(1, 9999),
            $amount ?? (float)random_int(1, 9999)
        );
    }
}