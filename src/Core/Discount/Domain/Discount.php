<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain;

use Teamleader\Discounts\Core\Shared\Domain\Customer\Customer;
use Teamleader\Discounts\Core\Shared\Domain\Order\Order;
use Teamleader\Discounts\Core\Shared\Domain\Product\Product;

interface Discount
{
    /**
     * Discount ID.
     *
     * @return DiscountId
     */
    public function id(): DiscountId;

    /**
     * Apply the discounts to order.
     *
     * @param Order     $order
     * @param Customer  $customer
     * @param Product[] $products
     *
     * @return DiscountResults
     */
    public function apply(Order $order, Customer $customer, iterable $products): DiscountResults;
}

