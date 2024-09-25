<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Shared\Domain\Order\Event;

use Teamleader\Discounts\Shared\Domain\Bus\Event\DomainEvent;

final class OrderCreated extends DomainEvent
{
    public function __construct(
        int $id,
        private readonly int $customer,
        private readonly array $items,
        private readonly float $total,
        ?string $eventId = null,
        ?float $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        int $id,
        array  $body,
        string $eventId,
        float  $occurredOn
    ): DomainEvent
    {
        return new self(
            $id,
            $body['customer-id'],
            $body['items'],
            $body['total'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return 'teamleader.order.created';
    }

    public function customer(): int
    {
        return $this->customer;
    }

    public function items(): array
    {
        return $this->items;
    }

    public function total(): float
    {
        return $this->total;
    }

    public function toPrimitives(): array
    {
        return [
            'customer-id' => $this->customer(),
            'items'       => $this->items(),
            'total'       => $this->total()
        ];
    }
}