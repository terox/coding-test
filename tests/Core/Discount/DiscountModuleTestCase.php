<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Core\Discount;

use Mockery\MockInterface;
use Teamleader\Discounts\Core\Discount\Domain\DiscountRepository;
use Teamleader\Discounts\Core\Discount\Domain\Discounts;
use Teamleader\Discounts\Tests\Shared\Infrastructure\Testing\PHPUnit\TestCase;

class DiscountModuleTestCase extends TestCase
{
    private DiscountRepository|MockInterface $repository;

    public function repositoryReturnNextDiscounts(Discounts $discounts): void
    {
        $this->repository()
            ->expects('findAll')
            ->andReturn($discounts);
    }

    public function repository(): DiscountRepository|MockInterface
    {
        return $this->repository ??= $this->mock(DiscountRepository::class);
    }
}