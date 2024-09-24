<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain\ValueObject;

/**
 * Represents an integer or float number.
 */
class Number
{
    public function __construct(
        private readonly int|float $value
    ) {
    }

    public function value(): int|float
    {
        return $this->value;
    }
}