<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Domain\Bus\Event;

abstract class DomainEvent
{
    public function __construct(
        private readonly int $aggregateId,
        private ?string $eventId = null,
        private ?float $occurredOn = null
    ) {
        $this->eventId    = $eventId ?: uniqid('', true);
        $this->occurredOn = $occurredOn ?: microtime(true);
    }

    abstract public static function fromPrimitives(
        int $id,
        array $body,
        string $eventId,
        float $occurredOn
    ): self;

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    public function aggregateId(): int
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): float
    {
        return $this->occurredOn;
    }
}