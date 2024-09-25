<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain\Exception;

use Teamleader\Discounts\Shared\Domain\Exception\DomainException;

final class DiscountConfigurationPropertyMissing extends DomainException
{
    public function __construct(
        private readonly string $ruleClass,
        private readonly string $property
    ) {
        parent::__construct();
    }

    protected function errorMessage(): string
    {
        return sprintf('The discount <%s> expected a property <%s>.', $this->ruleClass, $this->property);
    }

    protected function errorCode(): int
    {
        return 102;
    }
}