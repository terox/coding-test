<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Customer\Application;

use Teamleader\Discounts\Core\Shared\Domain\Customer\Customer;
use Teamleader\Discounts\Shared\Domain\Bus\Query\Response;

final readonly class CustomerResponse implements Response, Customer
{
    public function __construct(
        private int $id,
        private string $name,
        private string $createdAt,
        private float $revenue
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function revenue(): float
    {
        return $this->revenue;
    }

    public function toPrimitives(): array
    {
        return [
            'id'         => $this->id(),
            'name'       => $this->name(),
            'created_at' => $this->createdAt(),
            'revenue'    => $this->revenue()
        ];
    }
}