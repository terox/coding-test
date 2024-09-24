<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain;

interface DiscountRepository
{
    public function findAll(): Discounts;

    public function findByCode(DiscountCode $code): ?Discount;
}