<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain\Type;

use Teamleader\Discounts\Core\Discount\Domain\Type\DiscountCustomerRevenue;
use Teamleader\Discounts\Tests\Core\Discount\Domain\DiscountConfigurationMother;
use Teamleader\Discounts\Tests\Core\Discount\Domain\DiscountIdMother;
use Teamleader\Discounts\Tests\Core\Discount\Domain\DiscountNameMother;

final class DiscountCustomerRevenueMother
{
    public static function withRevenue(float $threshold, int $discount): DiscountCustomerRevenue
    {
        return new DiscountCustomerRevenue(
            DiscountIdMother::create(),
            DiscountNameMother::create(),
            DiscountConfigurationMother::withCustomerRevenue($threshold, $discount)
        );
    }

    public static function withConfiguration(array $configuration): DiscountCustomerRevenue
    {
        return new DiscountCustomerRevenue(
            DiscountIdMother::create(),
            DiscountNameMother::create(),
            DiscountConfigurationMother::create($configuration)
        );
    }
}