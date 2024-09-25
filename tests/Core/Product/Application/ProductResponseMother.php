<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Product\Application;

use Teamleader\Discounts\Core\Product\Application\ProductResponse;

final class ProductResponseMother
{
    public static function create(
        ?string $id = null,
        ?string $description = null,
        ?int $category = null,
        ?float $price = null
    ): ProductResponse {
        return new ProductResponse(
            $id ?? uniqid('product', true),
            $description ?? uniqid('description', true),
            $category ?? random_int(1, 9999),
            $price ?? (float)random_int(1, 9999)
        );
    }
}