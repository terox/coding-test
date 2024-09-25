<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain\Type;

use Teamleader\Discounts\Core\Discount\Domain\Type\DiscountCategoryFreeItem;
use Teamleader\Discounts\Tests\Core\Discount\Domain\DiscountConfigurationMother;
use Teamleader\Discounts\Tests\Core\Discount\Domain\DiscountIdMother;
use Teamleader\Discounts\Tests\Core\Discount\Domain\DiscountNameMother;

final class DiscountCategoryFreeItemMother
{
    public static function with(int $category, float $threshold): DiscountCategoryFreeItem
    {
        return new DiscountCategoryFreeItem(
            DiscountIdMother::create(),
            DiscountNameMother::create(),
            DiscountConfigurationMother::withCategoryFreeItem($category, $threshold)
        );
    }

    public static function withConfiguration(array $configuration): DiscountCategoryFreeItem
    {
        return new DiscountCategoryFreeItem(
            DiscountIdMother::create(),
            DiscountNameMother::create(),
            DiscountConfigurationMother::create($configuration)
        );
    }
}