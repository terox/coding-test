<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Order\Domain\Event;

use Teamleader\Discounts\Core\Order\Domain\Event\OrderCreated;
use Teamleader\Discounts\Shared\Domain\ValueObject\Identity;

final class OrderCreatedMother
{
    public static function create(
        ?int $id = null,
        ?int $customer = null,
        ?array $items = null,
        ?float $total = null
    ): OrderCreated {
        return new OrderCreated(
            $id ?? Identity::random()->value(),
            $customer ?? Identity::random()->value(),
            $items ?? [],
            $total ?? random_int(1, 1000)
        );
    }

    public static function createOrder1(): OrderCreated
    {
        $items = [
            [
                'product-id' => 'B102',
                'quantity'   => 10,
                'unit-price' => 4.99,
                'total'      => 49.9
            ]
        ];


        return self::create(1, 1, $items, 49.9);
    }

    public static function createOrder2(): OrderCreated
    {
        $items = [
            [
                'product-id' => 'B102',
                'quantity'   => 5,
                'unit-price' => 4.99,
                'total'      => 24.95
            ]
        ];

        return self::create(2, 2, $items, 24.95);
    }

    public static function createOrder3(): OrderCreated
    {
        $items = [
            [
                'product-id' => 'A101',
                'quantity'   => 2,
                'unit-price' => 9.75,
                'total'      => 19.5
            ],
            [
                'product-id' => 'A102',
                'quantity'   => 1,
                'unit-price' => 49.5,
                'total'      => 49.5
            ]
        ];

        return self::create(3, 3, $items, 69.0);
    }
}