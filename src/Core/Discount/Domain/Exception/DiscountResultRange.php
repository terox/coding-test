<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain\Exception;

use Teamleader\Discounts\Shared\Domain\Exception\InvalidRangeException;

final class DiscountResultRange extends InvalidRangeException
{
    protected function errorMessage(): string
    {
        return sprintf(
            'The discount result amount must be positive. The value <%s> is not in range is [%s-%s]',
            $this->value,
            $this->min,
            $this->max ?? 'inf'
        );
    }

    protected function errorCode(): int
    {
        return 104;
    }
}