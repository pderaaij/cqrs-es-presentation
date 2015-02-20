<?php
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Loader\YamlFileLoader;

require "./../vendor/autoload.php";

define('SQLITE_DB_PATH', realpath(__DIR__ . '/../cqrs-es-db.sqlite'));

$routes = new Symfony\Component\Routing\RouteCollection();
$locator = new FileLocator(array(__DIR__ . '/../config'));
$loader = new YamlFileLoader($locator);
$routes = $loader->load('routes.yml');

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