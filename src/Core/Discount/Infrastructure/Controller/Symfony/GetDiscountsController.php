<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Core\Discount\Infrastructure\Controller\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Teamleader\Discounts\Core\Discount\Application\Resolver\DiscountResolver;
use Teamleader\Discounts\Core\Shared\Application\OrderItemMessage;
use Teamleader\Discounts\Core\Shared\Application\OrderMessage;
use Teamleader\Discounts\Shared\Domain\Bus\Query\Response;

/**
 * Discount Microservice API endpoint.
 *
 * This is only for demostrative propose of the use case DiscountResolver. So:
 * - No input validations are taken into account.
 * - The decode/encode input/output are done in an ugly way
 *
 * For more information read the README.md
 */
final readonly class GetDiscountsController
{
    public function __construct(
        private DiscountResolver $resolver
    ) {
    }

    private function response(Response $response, int $status): JsonResponse
    {
        return new JsonResponse(
            array_map(
                static fn ($item) => $item instanceof Response ? $item->toPrimitives() : $item,
                $response->toPrimitives()
            ),
            $status
        );
    }

    public function __invoke(Request $request): JsonResponse
    {
        // 1. Deserialize body
        $data = json_decode($request->getContent(), true);

        // 2. Normalization, coercion and resolver call
        $results = ($this->resolver)(new OrderMessage(
            (int)$data['id'],
            (int)$data['customer-id'],
            array_map(static fn(array $item) => new OrderItemMessage(
                $item['product-id'],
                (int)$item['quantity'],
                (float)$item['unit-price'],
            ), $data['items']),
            (float)$data['total']
        ));

        return $this->response($results, 200);
    }
}