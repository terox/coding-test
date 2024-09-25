<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain\Exception;

abstract class InvalidRangeException extends DomainException
{
    public function __construct(
        protected readonly float $value,
        protected readonly float $min,
        protected readonly ?float $max = null
    ) {
        parent::__construct();
    }
}