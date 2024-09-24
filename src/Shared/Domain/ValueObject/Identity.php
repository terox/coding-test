<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain\ValueObject;

/**
 * Represents an identity for an object.
 */
class Identity
{
    public function __construct(
        private readonly int $value
    ) {
    }

    public static function random(): self
    {
        return new self(random_int(1, 9999));
    }

    public function sameValueAs(Identity $id): bool
    {
        return $this->value === $id->value();
    }

    public function value(): int
    {
        return $this->value;
    }
}