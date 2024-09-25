<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Application\Resolver;

use Teamleader\Discounts\Core\Customer\Application\FindById\GetCustomer;
use Teamleader\Discounts\Core\Discount\Application\DiscountResultConverter;
use Teamleader\Discounts\Core\Discount\Application\DiscountResultsResponse;
use Teamleader\Discounts\Core\Discount\Domain\DiscountRepository;
use Teamleader\Discounts\Core\Discount\Domain\DiscountResult;
use Teamleader\Discounts\Core\Discount\Domain\Event\DiscountApplied;
use Teamleader\Discounts\Core\Product\Application\FindById\GetProducts;
use Teamleader\Discounts\Core\Shared\Domain\Customer\Customer;
use Teamleader\Discounts\Core\Shared\Domain\Order\Order;
use Teamleader\Discounts\Core\Shared\Domain\Product\Product;
use Teamleader\Discounts\Shared\Domain\Bus\Event\EventBus;
use Teamleader\Discounts\Shared\Domain\Bus\Query\QueryBus;

/**
 * Discount Resolver.
 *
 * This use case calculates, from a received order, what discounts must be applied.
 */
final readonly class DiscountResolver
{
    public function __construct(
        private DiscountRepository $repository,
        private QueryBus $queryBus,
        private EventBus $eventBus
    ) {
    }

    private function toResponse(array $discounts): DiscountResultsResponse
    {
        return new DiscountResultsResponse(...array_map(
            static fn(DiscountResult $result) => (new DiscountResultConverter())($result),
            $discounts
        ));
    }

    public function __invoke(Order $order): DiscountResultsResponse
    {
        $discounts = $this->repository->findAll();

        if($discounts->isEmpty()) {
            return $this->toResponse([]);
        }

        // Gather information.
        // We collect related information to order that could be used to evaluate some discounts.

        /** @var Customer $customer */
        $customer = $this->queryBus->ask(new GetCustomer($order->customer()));

        /** @var Product[] $products */
        $products = $this->queryBus->ask(new GetProducts(...$order->itemsIds()));

        // Resolve discounts from order.
        // With all information, we are ready to evaluate what discounts could be applied to order

        $effectiveDiscounts = [];
        foreach($discounts as $discount) {
            $discountResults = $discount->apply($order, $customer, $products);

            if(!$discountResults->isApplied()) {
                continue;
            }

            // If order has an ID means that it is confirmed and processed, so its expected side effects.
            // In any other case, maybe we are only querying if the order have some discount.
            if(null !== $order->id()) {
                foreach($discountResults as $discountResult) {
                    $this->eventBus->publish(new DiscountApplied(
                        $discount->id()->value(),
                        $order->id(),
                        $discountResult->amount()
                    ));
                }
            }

            // We add the effective discount to stack
            $effectiveDiscounts += $discountResults->toArray();
        }

        return $this->toResponse($effectiveDiscounts);
    }
}