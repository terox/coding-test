<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Customer\Application\FindById;

use Teamleader\Discounts\Shared\Domain\Bus\Query\Query;

final readonly class GetCustomer implements Query
{
    public function __construct(
        private int $customer
    ) {
    }

    public function customer(): int
    {
        return $this->customer;
    }
}