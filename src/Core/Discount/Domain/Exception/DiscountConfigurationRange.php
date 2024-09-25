<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain\Exception;

use Teamleader\Discounts\Shared\Domain\Exception\InvalidRangeException;

final class DiscountConfigurationRange extends InvalidRangeException
{
    public function __construct(
        private readonly string $ruleClass,
        int $value, 
        int $min, 
        ?int $max = null
    ) {
        parent::__construct($value, $min, $max);
    }

    protected function errorMessage(): string
    {
        return sprintf(
            'The value for discount <%s> is invalid. The value <%s> is not in range is [%s-%s]',
            $this->ruleClass,
            $this->value,
            $this->min,
            $this->max ?? 'inf'
        );
    }

    protected function errorCode(): int
    {
        return 103;
    }
}