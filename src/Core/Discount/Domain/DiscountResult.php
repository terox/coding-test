<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain;

use Teamleader\Discounts\Core\Discount\Domain\Exception\DiscountResultRange;

final readonly class DiscountResult
{
    public function __construct(
        private DiscountId $id,
        private float $amount
    ) {
        if($this->amount < 0) {
            throw new DiscountResultRange($this->amount, 0);
        }
    }

    public static function create(DiscountId $id, float $amount): self
    {
        return new self($id, $amount);
    }

    public static function noDiscount(DiscountId $id): self
    {
        return new self($id, 0.0);
    }

    public function id(): DiscountId
    {
        return $this->id;
    }

    public function isApplied(): bool
    {
        return $this->amount > 0;
    }

    public function amount(): float
    {
        return $this->amount;
    }
}