<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain;

use Teamleader\Discounts\Core\Discount\Domain\DiscountConfiguration;

final class DiscountConfigurationMother
{
    public static function create(array $data = null): DiscountConfiguration
    {
        return new DiscountConfiguration($data);
    }

    public static function withCustomerRevenue(float $threshold, int $discount): DiscountConfiguration
    {
        return self::create([
            'threshold' => $threshold,
            'discount'  => $discount
        ]);
    }
}