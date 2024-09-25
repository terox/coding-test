<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain\Type;

use Teamleader\Discounts\Core\Discount\Domain\Type\DiscountCategoryCheapest;
use Teamleader\Discounts\Tests\Core\Discount\Domain\DiscountConfigurationMother;
use Teamleader\Discounts\Tests\Core\Discount\Domain\DiscountIdMother;
use Teamleader\Discounts\Tests\Core\Discount\Domain\DiscountNameMother;

final class DiscountCategoryCheapestMother
{
    public static function with(int $category, float $threshold, int $discount): DiscountCategoryCheapest
    {
        return new DiscountCategoryCheapest(
            DiscountIdMother::create(),
            DiscountNameMother::create(),
            DiscountConfigurationMother::withCategoryCheapest($category, $threshold, $discount)
        );
    }

    public static function withConfiguration(array $configuration): DiscountCategoryCheapest
    {
        return new DiscountCategoryCheapest(
            DiscountIdMother::create(),
            DiscountNameMother::create(),
            DiscountConfigurationMother::create($configuration)
        );
    }
}