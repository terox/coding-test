<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Shared\Domain\Order;

interface OrderItem
{
    public function productId(): string;

    public function quantity(): float;

    public function price(): float;
}