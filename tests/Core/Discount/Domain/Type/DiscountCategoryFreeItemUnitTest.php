<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain\Type;

use PHPUnit\Framework\Attributes\Test;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationInvalidTypeValue;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationPropertyMissing;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationRange;
use Teamleader\Discounts\Tests\Core\Discount\DiscountModuleTestCase;

final class DiscountCategoryFreeItemUnitTest extends DiscountModuleTestCase
{
    #[Test]
    public function it_should_throw_exception_on_missing_threshold_key(): void
    {
        $this->expectException(DiscountConfigurationPropertyMissing::class);

        DiscountCategoryFreeItemMother::withConfiguration([
            'the-key-not' => 'exists',
            'category_id' => 1,
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_threshold_value_type(): void
    {
        $this->expectException(DiscountConfigurationInvalidTypeValue::class);

        DiscountCategoryFreeItemMother::withConfiguration([
            'threshold' => '2',
            'category_id' => 1,
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_missing_category_key(): void
    {
        $this->expectException(DiscountConfigurationPropertyMissing::class);

        DiscountCategoryFreeItemMother::withConfiguration([
            'the-key-not' => 'exists',
            'threshold'   => 2,
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_category_value_type_string(): void
    {
        $this->expectException(DiscountConfigurationInvalidTypeValue::class);

        DiscountCategoryFreeItemMother::withConfiguration([
            'category_id' => '1',
            'threshold'   => 2,
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_category_value_type_float(): void
    {
        $this->expectException(DiscountConfigurationInvalidTypeValue::class);

        DiscountCategoryFreeItemMother::withConfiguration([
            'category_id' => 1.0,
            'threshold'   => 2,
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_category_range(): void
    {
        $this->expectException(DiscountConfigurationRange::class);

        DiscountCategoryFreeItemMother::withConfiguration([
            'category_id' => -1,
            'threshold'   => 2,
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_threshold_range(): void
    {
        $this->expectException(DiscountConfigurationRange::class);

        DiscountCategoryFreeItemMother::withConfiguration([
            'threshold'   => -2,
            'category_id' => 1,
        ]);
    }

    #[Test]
    public function it_should_be_valid_with_integer_and_float_numbers(): void
    {
        $discount1 = DiscountCategoryFreeItemMother::withConfiguration([
            'category_id' => 1,
            'threshold'   => 2,
        ]);

        $discount2 = DiscountCategoryFreeItemMother::withConfiguration([
            'category_id' => 1,
            'threshold'   => 2.0,
        ]);

        $this->assertSame(2, $discount1->config()->get('threshold'));
        $this->assertSame(2.0, $discount2->config()->get('threshold'));
    }
}