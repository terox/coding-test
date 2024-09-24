<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain;

use Teamleader\Discounts\Core\Shared\Domain\Order;

interface Discount
{
    public function apply(Order $order): Order;

    public function codename(): string;
}

