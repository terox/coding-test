<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Shared\Domain\Product;

interface Product
{
    public function id(): string;

    public function description(): string;

    public function category(): int;

    public function price(): float;
}