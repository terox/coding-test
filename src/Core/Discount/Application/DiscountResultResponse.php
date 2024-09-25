<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Application;

use Teamleader\Discounts\Shared\Domain\Bus\Query\Response;

final readonly class DiscountResultResponse implements Response
{
    public function __construct(
        private int $discountId,
        private float $amount
    ) {
    }

    public function discountId(): int
    {
        return $this->discountId;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function toPrimitives(): array
    {
        return [
            'discount_id' => $this->discountId(),
            'amount'      => $this->amount()
        ];
    }
}