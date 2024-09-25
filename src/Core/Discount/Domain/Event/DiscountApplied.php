<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Domain\Event;

use Teamleader\Discounts\Shared\Domain\Bus\Event\DomainEvent;

final class DiscountApplied extends DomainEvent
{
    public function __construct(
        int $discountId,
        private readonly int $orderId,
        private readonly float $amount,
        ?string $eventId = null,
        ?float $occurredOn = null
    ) {
        parent::__construct($discountId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        int $id,
        array $body,
        string $eventId,
        float $occurredOn
    ): DomainEvent {
        return new self(
            $id,
            $body['order-id'],
            $body['amount'],
            $eventId,
            $occurredOn
        );
    }

    public static function eventName(): string
    {
        return 'teamleader.discount.applied';
    }

    public function orderId(): int
    {
        return $this->orderId;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function toPrimitives(): array
    {
        return [
            'order-id' => $this->orderId,
            'amount'   => $this->amount
        ];
    }
}