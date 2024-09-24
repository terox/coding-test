<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain;

interface Collection
{
    /**
     * Return one element or null.
     *
     * @param int $index
     *
     * @return mixed
     */
    public function getOneOrNull(int $index): mixed;

    /**
     * Return all items in array
     *
     * @return array
     */
    public function toArray(): array;
}