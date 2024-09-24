<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain\Exception;

abstract class InvalidRangeException extends DomainException
{
    public function __construct(
        protected readonly int $value,
        protected readonly int $min,
        protected readonly ?int $max = null
    ) {
        parent::__construct();
    }
}