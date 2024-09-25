<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Product\Application;

use Teamleader\Discounts\Shared\Domain\Bus\Query\Response;
use Teamleader\Discounts\Shared\Domain\CollectionBase;

/**
 * @method iterable<ProductResponse> getIterator()
 * @method ProductResponse|null getOneOrNull()
 * @method ProductResponse[] toArray()
 */
final class ProductsResponse extends CollectionBase implements Response
{
    public function toPrimitives(): array
    {
        return $this->items;
    }
}