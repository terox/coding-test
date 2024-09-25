<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain;

use Teamleader\Discounts\Core\Discount\Domain\DiscountConfiguration;

final class DiscountConfigurationMother
{
    public static function withCustomerRevenue(float $threshold, int $discount): DiscountConfiguration
    {
        return new DiscountConfiguration([
            'threshold' => $threshold,
            'discount'  => $discount
        ]);
    }
}