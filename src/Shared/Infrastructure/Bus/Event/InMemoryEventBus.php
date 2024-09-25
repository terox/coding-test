<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Infrastructure\Bus\Event;

use Teamleader\Discounts\Shared\Domain\Bus\Event\DomainEvent;
use Teamleader\Discounts\Shared\Domain\Bus\Event\EventBus;

/**
 * In memory Event Bus.
 *
 * This class is only for demonstrative proposes.
 *
 * In real life, maybe it send the evento to some message broker like SQS, RabbitMQ, Redis... to be processed by another
 * microservice or service.
 */
final readonly class InMemoryEventBus implements EventBus
{
    public function publish(DomainEvent ...$events): void
    {
        // Your infrastructure code here to handle the event bus channel
    }
}