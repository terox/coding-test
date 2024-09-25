<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Application;

use Teamleader\Discounts\Core\Discount\Domain\DiscountResult;

final class DiscountResultConverter
{
    public function __invoke(DiscountResult $result): DiscountResultResponse
    {
        return new DiscountResultResponse(
            $result->id()->value(),
            $result->amount(),
        );
    }
}