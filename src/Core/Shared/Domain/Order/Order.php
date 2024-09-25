<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Shared\Domain\Order;

interface Order
{
    /**
     * Order ID.
     *
     * When it is null indicates that order is not confirmed and processed.
     *
     * @return int|null
     */
    public function id(): ?int;

    public function customer(): int;

    /**
     * @return OrderItem[]
     */
    public function items(): array;

    /**
     * @return string[]
     */
    public function itemsIds(): array;

    public function total(): float;
}