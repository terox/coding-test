<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain\Exception;

use Teamleader\Discounts\Shared\Domain\Exception\DomainException;

final class DiscountConfigurationInvalidTypeValue extends DomainException
{
    public function __construct(
        private readonly string $ruleClass,
        private readonly string $property,
        private readonly string $type
    ) {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf(
            'The discount <%s> expected that property <%s> has type <%s>',
            $this->ruleClass,
            $this->property,
            $this->type
        );
    }

    protected function errorCode(): int
    {
        return 101;
    }
}