<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain\ValueObject;

/**
 * Represents string.
 */
class Stringable
{
    public function __construct(
        private readonly string $value
    ) {
    }

    public function sameValueAs(string $value): bool
    {
        return $this->value === $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}