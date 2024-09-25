<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain;

use Teamleader\Discounts\Core\Discount\Domain\DiscountName;

final class DiscountNameMother
{
    public static function create(?string $name = null): DiscountName
    {
        return new DiscountName($name ?? uniqid('discount-name', true));
    }
}