<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain\Exception;

use Throwable;

abstract class DomainException extends \DomainException
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct($this->errorMessage(), $this->errorCode(), $previous);
    }

    abstract protected function errorMessage(): string;

    abstract protected function errorCode(): int;
}