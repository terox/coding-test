<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Shared\Application;

use Teamleader\Discounts\Core\Shared\Domain\Order\Order;

final readonly class OrderMessage implements Order
{
    private array $items;

    public function __construct(
        private int $orderId,
        private int $customerId,
        array $items,
        private float $total
    ) {
        $itemMessages = [];
        foreach($items as $item) {
            $itemMessages[] = new OrderItemMessage(
                $item['product-id'],
                $item['quantity'],
                $item['unit-price'],
            );
        }

        $this->items = $itemMessages;
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