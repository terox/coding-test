<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount\Application;

use PHPUnit\Framework\Attributes\Test;
use Teamleader\Discounts\Core\Discount\Application\Resolver\DiscountResolver;
use Teamleader\Discounts\Core\Discount\Application\Resolver\ResolveDiscountsOnOrderCreated;
use Teamleader\Discounts\Core\Discount\Domain\Discounts;
use Teamleader\Discounts\Tests\Core\Customer\Application\CustomerResponseMother;
use Teamleader\Discounts\Tests\Core\Discount\DiscountModuleTestCase;
use Teamleader\Discounts\Tests\Core\Discount\Domain\Event\DiscountAppliedMother;
use Teamleader\Discounts\Tests\Core\Discount\Domain\Type\DiscountCategoryCheapestMother;
use Teamleader\Discounts\Tests\Core\Discount\Domain\Type\DiscountCategoryFreeItemMother;
use Teamleader\Discounts\Tests\Core\Discount\Domain\Type\DiscountCustomerRevenueMother;
use Teamleader\Discounts\Tests\Core\Order\Domain\Event\OrderCreatedMother;
use Teamleader\Discounts\Tests\Core\Product\Application\ProductResponseMother;

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

    #[Test]
    public function it_should_apply_order_discount_based_on_customer_revenue(): void
    {
        $orderEvent          = OrderCreatedMother::createOrder2();
        $discountRevenue     = DiscountCustomerRevenueMother::withRevenue(1000.0, 10);
        $customer            = CustomerResponseMother::withRevenue(1505.95);
        $discountResultEvent = DiscountAppliedMother::create(
            $discountRevenue->id()->value(),
            $orderEvent->aggregateId(),
            2.495
        );

        $this->shouldReturnCustomer($customer);
        $this->shouldReturnProducts();
        $this->repositoryReturnNextDiscounts(new Discounts($discountRevenue));
        $this->shouldPublishDiscountAppliedDomainEvent($discountResultEvent);

        $this->notify($orderEvent, $this->subscriber);
    }

    #[Test]
    public function it_should_not_apply_order_discount_based_on_customer_revenue_due_min_threshold(): void
    {
        $orderEvent          = OrderCreatedMother::createOrder2();
        $discountRevenue     = DiscountCustomerRevenueMother::withRevenue(1600, 10);
        $customer            = CustomerResponseMother::withRevenue(1505.95);

        $this->shouldReturnCustomer($customer);
        $this->shouldReturnProducts();
        $this->repositoryReturnNextDiscounts(new Discounts($discountRevenue));
        $this->shouldNotPublishDomainEvent();

        $this->notify($orderEvent, $this->subscriber);
    }

    #[Test]
    public function it_should_apply_category_cheapest_discount(): void
    {
        $orderEvent          = OrderCreatedMother::createOrder3();
        $discountCheapest    = DiscountCategoryCheapestMother::with(1, 2, 20);
        $customer            = CustomerResponseMother::create();
        $discountResultEvent = DiscountAppliedMother::create(
            $discountCheapest->id()->value(),
            $orderEvent->aggregateId(),
            3.9
        );

        $this->shouldReturnCustomer($customer);
        $this->shouldReturnProducts(
            ProductResponseMother::create('A101', 'Screwdriver', 1, 9.75),
            ProductResponseMother::create('A102', 'Electric screwdriver', 1, 49.5),
        );
        $this->repositoryReturnNextDiscounts(new Discounts($discountCheapest));
        $this->shouldPublishDiscountAppliedDomainEvent($discountResultEvent);

        $this->notify($orderEvent, $this->subscriber);
    }

    #[Test]
    public function it_should_apply_not_apply_category_cheapest_discount_due_threshold(): void
    {
        $orderEvent          = OrderCreatedMother::createOrder3();
        $discountCheapest    = DiscountCategoryCheapestMother::with(1, 5, 20);
        $customer            = CustomerResponseMother::create();

        $this->shouldReturnCustomer($customer);
        $this->shouldReturnProducts(
            ProductResponseMother::create('A101', 'Screwdriver', 1, 9.75),
            ProductResponseMother::create('A102', 'Electric screwdriver', 1, 49.5),
        );
        $this->repositoryReturnNextDiscounts(new Discounts($discountCheapest));
        $this->shouldNotPublishDomainEvent();

        $this->notify($orderEvent, $this->subscriber);
    }

    #[Test]
    public function it_should_apply_category_free_item_discount(): void
    {
        $orderEvent          = OrderCreatedMother::createOrder1();
        $discountCheapest    = DiscountCategoryFreeItemMother::with(2, 5);
        $customer            = CustomerResponseMother::create();
        $discountResultEvent = DiscountAppliedMother::create(
            $discountCheapest->id()->value(),
            $orderEvent->aggregateId(),
            4.99
        );

        $this->shouldReturnCustomer($customer);
        $this->shouldReturnProducts(
            ProductResponseMother::create('B101', 'Basic on-off switch', 2, 4.99),
            ProductResponseMother::create('B102', 'Press button', 2, 4.99),
            ProductResponseMother::create('B103', 'Switch with motion detector', 2, 12.95),
        );
        $this->repositoryReturnNextDiscounts(new Discounts($discountCheapest));
        $this->shouldPublishDiscountAppliedDomainEvent($discountResultEvent);

        $this->notify($orderEvent, $this->subscriber);
    }

    #[Test]
    public function it_should_not_apply_category_free_item_discount_due_threshold(): void
    {
        $orderEvent          = OrderCreatedMother::createOrder1();
        $discountCheapest    = DiscountCategoryFreeItemMother::with(2, 10);
        $customer            = CustomerResponseMother::create();

        $this->shouldReturnCustomer($customer);
        $this->shouldReturnProducts(
            ProductResponseMother::create('B101', 'Basic on-off switch', 2, 4.99),
            ProductResponseMother::create('B102', 'Press button', 2, 4.99),
            ProductResponseMother::create('B103', 'Switch with motion detector', 2, 12.95),
        );
        $this->repositoryReturnNextDiscounts(new Discounts($discountCheapest));
        $this->shouldNotPublishDomainEvent();

        $this->notify($orderEvent, $this->subscriber);
    }
}