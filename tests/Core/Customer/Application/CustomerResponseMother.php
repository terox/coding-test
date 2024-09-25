<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Customer\Application;

use Teamleader\Discounts\Core\Customer\Application\CustomerResponse;

final class CustomerResponseMother
{
    public static function create(
        ?int $id = null,
        ?string $name = null,
        ?string $since = null,
        ?float $revenue = null
    ): CustomerResponse {
        return new CustomerResponse(
            $id ?? 1,
            $name ?? uniqid('customer-name', true),
            $since ?? date('Y-m-d'),
            $revenue ?? 100.0
        );
    }

    public static function withRevenue(float $revenue): CustomerResponse
    {
        return self::create(1, null, null, $revenue);
    }
}