<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Shared\Application;

use Teamleader\Discounts\Core\Shared\Domain\Order\OrderItem;

final readonly class OrderItemMessage implements OrderItem
{
    public function __construct(
        private string $id,
        private float $quantity,
        private float $price,
    ) {
    }

    public function productId(): string
    {
        return $this->id;
    }

    public function quantity(): float
    {
        return $this->quantity;
    }

    public function price(): float
    {
        return $this->price;
    }
}