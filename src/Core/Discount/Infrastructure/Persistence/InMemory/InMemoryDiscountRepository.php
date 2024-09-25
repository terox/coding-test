<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Infrastructure\Persistence\InMemory;

use Teamleader\Discounts\Core\Discount\Domain\Discount;
use Teamleader\Discounts\Core\Discount\Domain\DiscountCode;
use Teamleader\Discounts\Core\Discount\Domain\DiscountConfiguration;
use Teamleader\Discounts\Core\Discount\Domain\DiscountId;
use Teamleader\Discounts\Core\Discount\Domain\DiscountName;
use Teamleader\Discounts\Core\Discount\Domain\DiscountRepository;
use Teamleader\Discounts\Core\Discount\Domain\Discounts;
use Teamleader\Discounts\Core\Discount\Domain\Type\DiscountCategoryCheapest;
use Teamleader\Discounts\Core\Discount\Domain\Type\DiscountCustomerRevenue;

class InMemoryDiscountRepository implements DiscountRepository
{
    public function findAll(): Discounts
    {
        return new Discounts(
            new DiscountCustomerRevenue(
                new DiscountId(1),
                new DiscountName('Customer Revenue +1000€ => 10%'),
                new DiscountConfiguration([
                    'threshold' => 1000,
                    'discount'  => 10
                ])
            ),
            new DiscountCategoryCheapest(
                new DiscountId(2),
                new DiscountName('Category 1 Discount for 2 or more items'),
                new DiscountConfiguration([
                    'category_id' => 1,
                    'threshold'   => 2,
                    'discount'    => 20
                ])
            )
        );
    }

    public function findByCode(DiscountCode $code): ?Discount
    {
        // Demostrative porpoises
        return null;
    }
}