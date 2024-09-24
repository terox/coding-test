<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain\ValueObject;

/**
 * Represents a data structure.
 */
class Data
{
    public function __construct(
        private readonly array $data
    ) {
    }
}