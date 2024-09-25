<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Domain;

use Teamleader\Discounts\Core\Discount\Domain\DiscountId;

final class DiscountIdMother
{
    public static function create(?int $id = null): DiscountId
    {
        return new DiscountId($id ?? random_int(1, 9999));
    }
}