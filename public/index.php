<?php
require "./../vendor/autoload.php";

$routes = new Symfony\Component\Routing\RouteCollection();
$routes->add(
    'index', 
    new Symfony\Component\Routing\Route(
        '/', 
        array('_controller' => '\CESPres\Controllers\Index::index')
    )
);

$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();

$matcher = new Symfony\Component\Routing\Matcher\UrlMatcher($routes, new \Symfony\Component\Routing\RequestContext());


$dispatcher = new Symfony\Component\EventDispatcher\EventDispatcher();
$dispatcher->addSubscriber(new Symfony\Component\HttpKernel\EventListener\RouterListener($matcher));

$resolver = new Symfony\Component\HttpKernel\Controller\ControllerResolver();
$kernel = new Symfony\Component\HttpKernel\HttpKernel($dispatcher, $resolver);

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);