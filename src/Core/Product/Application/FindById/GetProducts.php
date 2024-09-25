<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Product\Application\FindById;

use Teamleader\Discounts\Shared\Domain\Bus\Query\Query;

final class GetProducts implements Query
{
    private array $ids;

    public function __construct(
        string ...$ids
    ) {
        $this->ids = $ids;
    }

    public function ids(): array
    {
        return $this->ids;
    }
}