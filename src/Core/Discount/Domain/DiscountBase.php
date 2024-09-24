<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain;

abstract class DiscountBase implements Discount
{
    public function __construct(
        private readonly DiscountId $id,
        private readonly DiscountName $name,
        private readonly DiscountConfiguration $config,
        private readonly ?DiscountCode $code = null,
    ) {
    }

    public function id(): DiscountId
    {
        return $this->id;
    }

    public function name(): DiscountName
    {
        return $this->name;
    }

    public function config(): DiscountConfiguration
    {
        return $this->config;
    }

    public function code(): DiscountCode
    {
        return $this->code;
    }
}