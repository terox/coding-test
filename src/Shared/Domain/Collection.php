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
     * Check if collection has items or not.
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Return all items in array
     *
     * @return array
     */
    public function toArray(): array;
}