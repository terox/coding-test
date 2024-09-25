<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Application;

use Teamleader\Discounts\Shared\Domain\Bus\Query\Response;

final class DiscountResultsResponse implements Response
{
    private array $responses;

    public function __construct(DiscountResultResponse ...$responses)
    {
        $this->responses = $responses;
    }

    public function toPrimitives(): array
    {
        return $this->responses;
    }
}