<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain\Type;

use Teamleader\Discounts\Core\Discount\Domain\DiscountBase;
use Teamleader\Discounts\Core\Discount\Domain\DiscountCode;
use Teamleader\Discounts\Core\Discount\Domain\DiscountConfiguration;
use Teamleader\Discounts\Core\Discount\Domain\DiscountId;
use Teamleader\Discounts\Core\Discount\Domain\DiscountName;
use Teamleader\Discounts\Core\Discount\Domain\DiscountResult;
use Teamleader\Discounts\Core\Discount\Domain\DiscountResults;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationInvalidTypeValue;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationPropertyMissing;
use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountConfigurationRange;
use Teamleader\Discounts\Core\Shared\Domain\Customer\Customer;
use Teamleader\Discounts\Core\Shared\Domain\Order\Order;

final class DiscountCustomerRevenue extends DiscountBase
{
    private const string KEY_THRESHOLD = 'threshold';
    private const string KEY_DISCOUNT  = 'discount';

    public function __construct(
        DiscountId $id,
        DiscountName $name,
        DiscountConfiguration $config,
        ?DiscountCode $code = null,
    )
    {
        $this->assertThreshold($config);
        $this->assertDiscount($config);

        parent::__construct($id, $name, $config, $code);
    }

    private function assertThreshold(DiscountConfiguration $config): void
    {
        if(!$config->hasKey(self::KEY_THRESHOLD)) {
            throw new DiscountConfigurationPropertyMissing(self::class, self::KEY_THRESHOLD);
        }

        if(!$config->isKeyType(self::KEY_THRESHOLD, 'number')) {
            throw new DiscountConfigurationInvalidTypeValue(self::class, self::KEY_THRESHOLD, 'number');
        }

        if(($value = $config->get(self::KEY_THRESHOLD)) < 0) {
            throw new DiscountConfigurationRange(self::class, $value, 0);
        }
    }

    private function assertDiscount(DiscountConfiguration $config): void
    {
        if(!$config->hasKey(self::KEY_DISCOUNT)) {
            throw new DiscountConfigurationPropertyMissing(self::class, self::KEY_DISCOUNT);
        }

        if(!$config->isKeyType(self::KEY_DISCOUNT, 'number')) {
            throw new DiscountConfigurationInvalidTypeValue(self::class, self::KEY_DISCOUNT, 'number');
        }

        if(($value = $config->get(self::KEY_DISCOUNT)) < 0) {
            throw new DiscountConfigurationRange(self::class, $value, 0, 100);
        }
    }

    public function apply(Order $order, Customer $customer, iterable $products): DiscountResults
    {
        if($customer->revenue() <= $this->config()->get(self::KEY_THRESHOLD)) {
            return DiscountResults::empty();
        }

        return new DiscountResults(
            DiscountResult::create(
                $this->id(),
                $order->total() * ($this->config()->get(self::KEY_DISCOUNT) / 100)
            )
        );
    }
}