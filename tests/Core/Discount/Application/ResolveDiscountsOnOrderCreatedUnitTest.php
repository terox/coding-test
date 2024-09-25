<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Application;

use PHPUnit\Framework\Attributes\Test;
use Teamleader\Discounts\Core\Discount\Application\Resolver\DiscountResolver;
use Teamleader\Discounts\Core\Discount\Application\Resolver\ResolveDiscountsOnOrderCreated;
use Teamleader\Discounts\Core\Discount\Domain\Discounts;
use Teamleader\Discounts\Tests\Core\Discount\DiscountModuleTestCase;
use Teamleader\Discounts\Tests\Core\Order\Domain\Event\OrderCreatedMother;

final class ResolveDiscountsOnOrderCreatedUnitTest extends DiscountModuleTestCase
{
    private ?ResolveDiscountsOnOrderCreated $subscriber;

    protected function setUp(): void
    {
        $this->subscriber = new ResolveDiscountsOnOrderCreated(
            new DiscountResolver(
                $this->repository(),
                $this->queryBus(),
                $this->eventBus()
            )
        );
    }

    #[Test]
    public function it_should_not_apply_discounts_when_there_arent_discounts_available(): void
    {
        $event = OrderCreatedMother::createOrder1();

        $this->repositoryReturnNextDiscounts(Discounts::empty());
        $this->shouldNotPublishDomainEvent();

        $this->notify($event, $this->subscriber);
    }
}