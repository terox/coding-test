<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain\Type;

use PHPUnit\Framework\Attributes\Test;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationInvalidTypeValue;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationPropertyMissing;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationRange;
use Teamleader\Discounts\Tests\Core\Discount\DiscountModuleTestCase;

final class DiscountCustomerRevenueTestCase extends DiscountModuleTestCase
{
    #[Test]
    public function it_should_throw_exception_on_missing_threshold_key(): void
    {
        $this->expectException(DiscountConfigurationPropertyMissing::class);

        DiscountCustomerRevenueMother::withConfiguration([
            'the-key-not' => 'exists'
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_threshold_value_type(): void
    {
        $this->expectException(DiscountConfigurationInvalidTypeValue::class);

        DiscountCustomerRevenueMother::withConfiguration([
            'threshold' => '1000.0'
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_threshold_range(): void
    {
        $this->expectException(DiscountConfigurationRange::class);

        DiscountCustomerRevenueMother::withConfiguration([
            'threshold' => -100
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_missing_discount_key(): void
    {
        $this->expectException(DiscountConfigurationPropertyMissing::class);

        DiscountCustomerRevenueMother::withConfiguration([
            'threshold' => 1000.0
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_discount_value_type(): void
    {
        $this->expectException(DiscountConfigurationInvalidTypeValue::class);

        DiscountCustomerRevenueMother::withConfiguration([
            'threshold' => 1000.0,
            'discount'  => '10'
        ]);
    }

    #[Test]
    public function it_should_throw_exception_on_invalid_discount_range(): void
    {
        $this->expectException(DiscountConfigurationRange::class);

        DiscountCustomerRevenueMother::withConfiguration([
            'threshold' => 1000.0,
            'discount'  => -10
        ]);
    }

    #[Test]
    public function it_should_be_valid_with_integer_and_float_numbers(): void
    {
        $discount1 = DiscountCustomerRevenueMother::withConfiguration([
            'threshold' => 1000,
            'discount'  => 10
        ]);

        $discount2 = DiscountCustomerRevenueMother::withConfiguration([
            'threshold' => 1000.0,
            'discount'  => 10.0
        ]);

        $this->assertSame(1000, $discount1->config()->get('threshold'));
        $this->assertSame(10, $discount1->config()->get('discount'));
        $this->assertSame(1000.0, $discount2->config()->get('threshold'));
        $this->assertSame(10.0, $discount2->config()->get('discount'));
    }
}