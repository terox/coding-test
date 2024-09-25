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

final class DiscountCategoryFreeItem extends DiscountBase
{
    private const string KEY_CATEGORY_ID = 'category_id';
    private const string KEY_THRESHOLD   = 'threshold';

    public function __construct(
        DiscountId $id,
        DiscountName $name,
        DiscountConfiguration $config,
        ?DiscountCode $code = null,
    )
    {
        $this->assertCategory($config);
        $this->assertThreshold($config);

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

        // 2. Calculate the numbers of free items

        $threshold = $this->config()->get(self::KEY_THRESHOLD);
        $discounts = [];
        foreach ($categoryItems as $item) {
            if($item->quantity() < $threshold) {
                continue;
            }

            $freeItems   = (int)($item->quantity() / ($threshold + 1));
            $totalAmount = $freeItems * $item->price();

            $discounts[] = DiscountResult::create($this->id(), $totalAmount);
        }

        return new DiscountResults(...$discounts);
    }
}