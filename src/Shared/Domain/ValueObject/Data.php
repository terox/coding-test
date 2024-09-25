<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain\ValueObject;

/**
 * Represents a data structure.
 */
class Data
{
    public function __construct(
        private readonly array $data
    ) {
    }

    public function hasKey(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function get(string $key): mixed
    {
        if(!$this->hasKey($key)) {
            return null;
        }

        return $this->data[$key];
    }

    public function isKeyType(string $key, string $type): bool
    {
        if(!$this->hasKey($key)) {
            return false;
        }

        $value = $this->get($key);

        return match ($type) {
            'int'   => is_int($value),
            'float' => is_float($value),
            default => false,
        };
    }
}