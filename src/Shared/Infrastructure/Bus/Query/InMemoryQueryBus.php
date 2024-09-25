<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Shared\Infrastructure\Bus\Query;

use Teamleader\Discounts\Core\Customer\Application\CustomerResponse;
use Teamleader\Discounts\Core\Customer\Application\FindById\GetCustomer;
use Teamleader\Discounts\Core\Product\Application\FindById\GetProducts;
use Teamleader\Discounts\Core\Product\Application\ProductResponse;
use Teamleader\Discounts\Core\Product\Application\ProductsResponse;
use Teamleader\Discounts\Shared\Domain\Bus\Query\Query;
use Teamleader\Discounts\Shared\Domain\Bus\Query\QueryBus;
use Teamleader\Discounts\Shared\Domain\Bus\Query\Response;

/**
 * In memory Query Bus.
 *
 * This class is only for demonstrative proposes.
 *
 * In real life, maybe it query some cache in the discount microservice.
 */
final class InMemoryQueryBus implements QueryBus
{
    private array $customers;
    private array $products;

    public function __construct()
    {
        $this->customers = json_decode(file_get_contents(__DIR__.'/../../../../../data/customers.json'), true);
        $this->products  = json_decode(file_get_contents(__DIR__.'/../../../../../data/products.json'), true);
    }

    public function ask(Query $query): ?Response
    {
        switch($query::class) {
            case GetCustomer::class:
                foreach($this->customers as $customer) {
                    if((int)$customer['id'] !== $query->customer()) {
                        continue;
                    }

                    return new CustomerResponse(
                        (int)$customer['id'],
                        $customer['name'],
                        $customer['since'],
                        (float)$customer['revenue']
                    );
                }

                break;

            case GetProducts::class:
                $responses = [];
                foreach($query->ids() as $id) {
                    foreach($this->products as $product) {
                        if($id === $product['id']) {
                            $responses[] = new ProductResponse(
                                $product['id'],
                                $product['description'],
                                (int)$product['category'],
                                (float)$product['price']
                            );
                        }
                    }
                }

                return new ProductsResponse($responses);

            default:
                throw new \RuntimeException(sprintf('The query <%s> have not a handler', $query::class));
        }

        return null;
    }
}