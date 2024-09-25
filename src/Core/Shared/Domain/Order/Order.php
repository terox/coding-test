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

    public function items(): array;

    public function itemsIds(): array;

    // TODO
    //public function discountCode(): ?string;

    public function total(): float;
}