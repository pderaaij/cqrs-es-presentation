<?php
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Route;

require "./../vendor/autoload.php";

define('SQLITE_DB_PATH', realpath(__DIR__ . '/../cqrs-es-db.sqlite'));

$routes = new Symfony\Component\Routing\RouteCollection();
$routes->add(
    'index', 
    new Symfony\Component\Routing\Route(
        '/', 
        array('_controller' => '\CESPres\Website\Controllers\Index::index')
    )
);

$routes->add(
    'product_view',
    new Symfony\Component\Routing\Route(
        '/nlayer/product/{productId}',
        array('_controller' => '\CESPres\NLayer\Product\Controllers\ProductController::get'),
        array('_method' => \Symfony\Component\HttpFoundation\Request::METHOD_GET)
    )
);

$routes->add(
    'product_update',
    new Symfony\Component\Routing\Route(
        '/nlayer/product/{productId}',
        array('_controller' => '\CESPres\NLayer\Product\Controllers\ProductController::post'),
        array('_method' => \Symfony\Component\HttpFoundation\Request::METHOD_POST)
    )
);

$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
$requestContext = new \Symfony\Component\Routing\RequestContext();
$requestContext->fromRequest($request);
$matcher = new Symfony\Component\Routing\Matcher\UrlMatcher($routes, $requestContext);

$dispatcher = new Symfony\Component\EventDispatcher\EventDispatcher();
$dispatcher->addSubscriber(new Symfony\Component\HttpKernel\EventListener\RouterListener($matcher));
$dispatcher->addListener(KernelEvents::EXCEPTION, array(new \CESPres\Website\Listeners\WebsiteExceptionListener(), 'onKernelException'));
$dispatcher->addListener(KernelEvents::CONTROLLER, array(new \CESPres\Website\Listeners\WebsiteControllerListener(), 'onKernelController'));

$resolver = new Symfony\Component\HttpKernel\Controller\ControllerResolver();
$kernel = new Symfony\Component\HttpKernel\HttpKernel($dispatcher, $resolver);

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);