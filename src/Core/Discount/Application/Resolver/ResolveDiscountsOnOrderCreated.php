<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Application\Resolver;

use Teamleader\Discounts\Core\Shared\Application\OrderItemMessage;
use Teamleader\Discounts\Core\Shared\Application\OrderMessage;
use Teamleader\Discounts\Core\Shared\Domain\Order\Event\OrderCreated;
use Teamleader\Discounts\Shared\Domain\Bus\Event\DomainEventSubscriber;

final readonly class ResolveDiscountsOnOrderCreated implements DomainEventSubscriber
{
    public function __construct(
        private DiscountResolver $resolver
    ) {
    }

    public static function subscribedTo(): array
    {
        return [ OrderCreated::class ];
    }

    public function __invoke(OrderCreated $event): void
    {
        $this->resolver->__invoke(new OrderMessage(
            $event->aggregateId(),
            $event->customer(),
            array_map(static fn(array $item) => new OrderItemMessage(
                $item['product-id'],
                (int)$item['quantity'],
                (float)$item['unit-price'],
            ), $event->items()),
            $event->total()
        ));
    }
}