<?php

use Symfony\Component\HttpFoundation\Request;
use Teamleader\Discounts\Core\Discount\Application\Resolver\DiscountResolver;
use Teamleader\Discounts\Core\Discount\Infrastructure\Controller\Symfony\GetDiscountsController;
use Teamleader\Discounts\Core\Discount\Infrastructure\Persistence\InMemory\InMemoryDiscountRepository;
use Teamleader\Discounts\Shared\Infrastructure\Bus\Event\InMemoryEventBus;
use Teamleader\Discounts\Shared\Infrastructure\Bus\Query\InMemoryQueryBus;

require_once dirname(__DIR__).'/vendor/autoload.php';

$request = Request::createFromGlobals();

if(!$request->isMethod('POST')) {
    die('Only POST allowed.');
}

// DEPENDENCY MANAGEMENT
$resolver = new DiscountResolver(
  new InMemoryDiscountRepository(),
  new InMemoryQueryBus(),
  new InMemoryEventBus(),
);

$controller = new GetDiscountsController($resolver);

// Process the request
$controller($request)->send();

