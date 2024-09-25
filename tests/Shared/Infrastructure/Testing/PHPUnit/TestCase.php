<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Shared\Infrastructure\Testing\PHPUnit;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Teamleader\Discounts\Shared\Domain\Bus\Event\DomainEvent;
use Teamleader\Discounts\Shared\Domain\Bus\Event\EventBus;
use Teamleader\Discounts\Shared\Domain\Bus\Query\QueryBus;

abstract class TestCase extends MockeryTestCase
{
    private QueryBus|MockInterface|null $queryBus = null;
    private EventBus|MockInterface|null $eventBus = null;

    protected function mock(string $class): MockInterface
    {
        return \Mockery::mock($class);
    }

    protected function queryBus(): QueryBus|MockInterface
    {
        return $this->queryBus ??= $this->mock(QueryBus::class);
    }

    protected function eventBus(): EventBus|MockInterface
    {
        return $this->eventBus ??= $this->mock(EventBus::class);
    }

    protected function notify(DomainEvent $event, callable $subscriber): void
    {
        $subscriber($event);
    }

    protected function shouldNotPublishDomainEvent(): void
    {
        $this->eventBus()
            ->allows('publish')
            ->never();
    }
}