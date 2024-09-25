<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount;

use Mockery\MockInterface;
use Teamleader\Discounts\Core\Customer\Application\CustomerResponse;
use Teamleader\Discounts\Core\Discount\Domain\DiscountRepository;
use Teamleader\Discounts\Core\Discount\Domain\Discounts;
use Teamleader\Discounts\Core\Discount\Domain\Event\DiscountApplied;
use Teamleader\Discounts\Core\Product\Application\ProductsResponse;
use Teamleader\Discounts\Tests\Shared\Infrastructure\Testing\PHPUnit\TestCase;

abstract class DiscountModuleTestCase extends TestCase
{
    private DiscountRepository|MockInterface $repository;

    protected function repositoryReturnNextDiscounts(Discounts $discounts): void
    {
        $this->repository()
            ->expects('findAll')
            ->andReturn($discounts);
    }

    protected function shouldReturnCustomer(CustomerResponse $customer): void
    {
        $this->queryBus()
            ->expects('ask')
            ->andReturn($customer);
    }

    protected function shouldReturnProducts(ProductsResponse $products): void
    {
        $this->queryBus()
            ->expects('ask')
            ->andReturn($products);
    }

    protected function shouldPublishDiscountAppliedDomainEvent(DiscountApplied $applied) :void
    {
        $this->eventBus()
            ->expects('publish')
            ->withArgs(static function(DiscountApplied $arg) use ($applied) {
                return $arg->aggregateId() === $applied->aggregateId() &&
                    $arg->orderId() === $applied->orderId() &&
                    $arg->amount() === $applied->amount();
            })
            ->andReturnNull();
    }

    protected function repository(): DiscountRepository|MockInterface
    {
        return $this->repository ??= $this->mock(DiscountRepository::class);
    }
}