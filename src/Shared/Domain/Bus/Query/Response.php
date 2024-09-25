<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain\Bus\Query;

interface Response
{
    public function toPrimitives(): array;
}