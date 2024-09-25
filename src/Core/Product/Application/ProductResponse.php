<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Product\Application;

use Teamleader\Discounts\Core\Shared\Domain\Product\Product;
use Teamleader\Discounts\Shared\Domain\Bus\Query\Response;

final readonly class ProductResponse implements Response, Product
{
    public function __construct(
        private string $id,
        private string $description,
        private int $category,
        private float $price
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function category(): int
    {
        return $this->category;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function toPrimitives(): array
    {
        return [
            'id'          => $this->id(),
            'description' => $this->description(),
            'category'    => $this->category(),
            'price'       => $this->price()
        ];
    }
}