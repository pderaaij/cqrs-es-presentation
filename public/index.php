<?php

require "./../vendor/autoload.php";

define('CONFIG_PATH', realpath(__DIR__ . '/../config'));
define('SQLITE_DB_PATH', realpath(__DIR__ . '/../cqrs-es-db.sqlite'));


$repository = new \CESPres\CQRS\Product\Repositories\ProductViewRepository();
$queryBus = new \CESPres\CQRS\Core\ServiceBus\QueryBus();
$queryBus->registerHandler(new \CESPres\CQRS\Product\QueryHandlers\ProductQueryHandler($repository));
CESPres\Core\Registry\Register::register('query_bus', $queryBus);

\CESPres\Core\Bootstrap::boot();