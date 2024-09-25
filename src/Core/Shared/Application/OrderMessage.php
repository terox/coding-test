<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Shared\Application;

use Teamleader\Discounts\Core\Shared\Domain\Order\Order;

final readonly class OrderMessage implements Order
{
    public function __construct(
        private int $orderId,
        private int $customerId,
        private array $items,
        private float $total
    ) {
    }

    public function id(): int
    {
        return $this->orderId;
    }

    public function customer(): int
    {
        return $this->customerId;
    }

    public function items(): array
    {
        return $this->items;
    }

    public function itemsIds(): array
    {
        return array_map(static fn(OrderItemMessage $item) => $item->productId(), $this->items);
    }

    public function total(): float
    {
        return $this->total;
    }
}