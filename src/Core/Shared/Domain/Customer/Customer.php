<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Shared\Domain\Customer;

interface Customer
{
    public function id(): int;

    public function name(): string;

    public function createdAt(): string;

    public function revenue(): float;
}