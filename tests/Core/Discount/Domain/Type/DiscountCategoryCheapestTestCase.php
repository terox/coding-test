<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain\Type;

use PHPUnit\Framework\Attributes\Test;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationInvalidTypeValue;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationPropertyMissing;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationRange;
use Teamleader\Discounts\Tests\Core\Discount\DiscountModuleTestCase;

final class DiscountCategoryCheapestTestCase extends DiscountModuleTestCase
{
    #[Test]
    public function it_should_throw_exception_on_missing_threshold_key(): void
    {
        $this->expectException(DiscountConfigurationPropertyMissing::class);

        DiscountCategoryCheapestMother::withConfiguration([
            'the-key-not' => 'exists',
            'category_id' => 1,
            'discount'    => 20
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_threshold_value_type(): void
    {
        $this->expectException(DiscountConfigurationInvalidTypeValue::class);

        DiscountCategoryCheapestMother::withConfiguration([
            'threshold' => '2',
            'category_id' => 1,
            'discount'    => 20
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_missing_category_key(): void
    {
        $this->expectException(DiscountConfigurationPropertyMissing::class);

        DiscountCategoryCheapestMother::withConfiguration([
            'the-key-not' => 'exists',
            'threshold'   => 2,
            'discount'    => 20
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_category_value_type_string(): void
    {
        $this->expectException(DiscountConfigurationInvalidTypeValue::class);

        DiscountCategoryCheapestMother::withConfiguration([
            'category_id' => '1',
            'threshold'   => 2,
            'discount'    => 20
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_category_value_type_float(): void
    {
        $this->expectException(DiscountConfigurationInvalidTypeValue::class);

        DiscountCategoryCheapestMother::withConfiguration([
            'category_id' => 1.0,
            'threshold'   => 2,
            'discount'    => 20
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_category_range(): void
    {
        $this->expectException(DiscountConfigurationRange::class);

        DiscountCategoryCheapestMother::withConfiguration([
            'category_id' => -1,
            'threshold'   => 2,
            'discount'    => 20
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_threshold_range(): void
    {
        $this->expectException(DiscountConfigurationRange::class);

        DiscountCategoryCheapestMother::withConfiguration([
            'threshold'   => -2,
            'category_id' => 1,
            'discount'    => 20
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_missing_discount_key(): void
    {
        $this->expectException(DiscountConfigurationPropertyMissing::class);

        DiscountCategoryCheapestMother::withConfiguration([
            'threshold' => 1000.0
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_discount_value_type(): void
    {
        $this->expectException(DiscountConfigurationInvalidTypeValue::class);

        DiscountCategoryCheapestMother::withConfiguration([
            'threshold'   => 1000.0,
            'discount'    => '10',
            'category_id' => 1,
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_discount_range(): void
    {
        $this->expectException(DiscountConfigurationRange::class);

        DiscountCategoryCheapestMother::withConfiguration([
            'category_id' => 1,
            'threshold'   => 1000.0,
            'discount'    => -10
        ]);
    }

    #[Test]
    public function it_should_be_valid_with_integer_and_float_numbers(): void
    {
        $discount1 = DiscountCategoryCheapestMother::withConfiguration([
            'category_id' => 1,
            'threshold'   => 2,
            'discount'    => 20
        ]);

        $discount2 = DiscountCategoryCheapestMother::withConfiguration([
            'category_id' => 1,
            'threshold'   => 2.0,
            'discount'    => 20.0
        ]);

        $this->assertSame(2, $discount1->config()->get('threshold'));
        $this->assertSame(20, $discount1->config()->get('discount'));
        $this->assertSame(2.0, $discount2->config()->get('threshold'));
        $this->assertSame(20.0, $discount2->config()->get('discount'));
    }
}