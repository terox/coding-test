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
use Teamleader\Discounts\Core\Shared\Domain\Order\OrderItem;
use Teamleader\Discounts\Core\Shared\Domain\Product\Product;

final class DiscountCategoryCheapest extends DiscountBase
{
    private const string KEY_CATEGORY_ID = 'category_id';
    private const string KEY_THRESHOLD   = 'threshold';
    private const string KEY_DISCOUNT    = 'discount';

    public function __construct(
        DiscountId $id,
        DiscountName $name,
        DiscountConfiguration $config,
        ?DiscountCode $code = null,
    )
    {
        $this->assertCategory($config);
        $this->assertThreshold($config);
        $this->assertDiscount($config);

        parent::__construct($id, $name, $config, $code);
    }

    private function assertCategory(DiscountConfiguration $config): void
    {
        if(!$config->hasKey(self::KEY_CATEGORY_ID)) {
            throw new DiscountConfigurationPropertyMissing(self::class, self::KEY_CATEGORY_ID);
        }

        if(!$config->isKeyType(self::KEY_CATEGORY_ID, 'int')) {
            throw new DiscountConfigurationInvalidTypeValue(self::class, self::KEY_CATEGORY_ID, 'int');
        }

        if(($value = $config->get(self::KEY_CATEGORY_ID)) < 0) {
            throw new DiscountConfigurationRange(self::class, $value, 1);
        }
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
            throw new DiscountConfigurationRange(self::class, $value, 0);
        }
    }

    /**
     * @param OrderItem $item
     * @param int       $category
     * @param Product[] $products
     *
     * @return bool
     */
    private function itemBelongsToCategory(OrderItem $item, int $category, iterable $products): bool
    {
        foreach($products as $product) {
            if($item->productId() !== $product->id()) {
                continue;
            }

            if($product->category() === $category) {
                return true;
            }
        }

        return false;
    }

    public function apply(Order $order, Customer $customer, iterable $products): DiscountResults
    {
        $targetCategory = $this->config()->get(self::KEY_CATEGORY_ID);

        // 1. Locate the items that belongs to the target category

        $categoryItems = [];
        foreach($order->items() as $item) {
            if(!$this->itemBelongsToCategory($item, $targetCategory, $products)) {
                continue;
            }

            $categoryItems[] = $item;
        }

        if(0 === count($categoryItems)) {
            return DiscountResults::empty();
        }

        // 2. Count total items to be sure that they reach the minimum threshold

        $totalItems = array_reduce(
            $categoryItems,
            static fn(int $carry, OrderItem $item) => $carry + $item->quantity(),
            0
        );

        if($totalItems < $this->config()->get(self::KEY_THRESHOLD)) {
            return DiscountResults::empty();
        }

        // 3. Get the cheapest product
        // Note: we only keep the last one item with the cheapest product. So, we only apply the discount once.

        $cheapestItem = null;
        foreach ($categoryItems as $item) {
            if (null === $cheapestItem || $item->price() < $cheapestItem->price()) {
                $cheapestItem = $item;
            }
        }

        // 4. Apply the discount

        return new DiscountResults(
            DiscountResult::create(
                $this->id(),
                ($cheapestItem->quantity() * $cheapestItem->price()) * ($this->config()->get(self::KEY_DISCOUNT) / 100)
            )
        );
    }
}