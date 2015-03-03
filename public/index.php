<?php

require "./../vendor/autoload.php";

define('CONFIG_PATH', realpath(__DIR__ . '/../config'));
define('SQLITE_READ_DB_PATH', realpath(__DIR__ . '/../cqrs-read-db.sqlite'));


// @TODO much nicer

if (strpos($_SERVER['REQUEST_URI'], '/es/') !== false) {
    define('SQLITE_DB_PATH', realpath(__DIR__ . '/../cqrs-es-eventstore.sqlite'));

    $repository = new \CESPres\ES\Product\Repositories\EventRepository();
    $commandBus = new \CESPres\ES\Core\ServiceBus\CommandBus();
    $commandBus->registerHandler(new \CESPres\ES\Product\CommandHandlers\CreateProductCommandHandler($repository));
    CESPres\Core\Registry\Register::register('command_bus', $commandBus);

    $eventBus = new \CESPres\ES\Core\Eventing\SimpleEventBus();
    $productWasCreatedListener = new \CESPres\ES\Product\EventListeners\ProductCreatedEventListener();
    $eventBus->subscribe($productWasCreatedListener);
    CESPres\Core\Registry\Register::register('event_bus', $eventBus);

} else {
    define('SQLITE_DB_PATH', realpath(__DIR__ . '/../cqrs-es-db.sqlite'));

    $repository = new \CESPres\CQRS\Product\Repositories\ProductViewRepository();
    $queryBus = new \CESPres\CQRS\Core\ServiceBus\QueryBus();
    $queryBus->registerHandler(new \CESPres\CQRS\Product\QueryHandlers\ProductQueryHandler($repository));
    CESPres\Core\Registry\Register::register('query_bus', $queryBus);

    $productRepository = new \CESPres\CQRS\Product\Repositories\ProductRepository();
    $commandBus = new \CESPres\CQRS\Core\ServiceBus\CommandBus();
    $commandBus->registerHandler(new \CESPres\CQRS\Product\CommandHandlers\CreateProductCommandHandler($productRepository, $repository));
    CESPres\Core\Registry\Register::register('command_bus', $commandBus);
}

\CESPres\Core\Bootstrap::boot();