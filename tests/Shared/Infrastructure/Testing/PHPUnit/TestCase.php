<?php

declare(strict_types=1);

namespace Teamleader\Discounts\Tests\Shared\Infrastructure\Testing\PHPUnit;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;

abstract class TestCase extends MockeryTestCase
{
    protected function mock(string $class): MockInterface
    {
        return \Mockery::mock($class);
    }
}