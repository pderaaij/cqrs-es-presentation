<?php
namespace CESPres\Core;


use CESPres\Website\Listeners\WebsiteControllerListener;
use CESPres\Website\Listeners\WebsiteExceptionListener;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RouteCollection;

class Bootstrap {

    public static function boot() {
        $routes = self::loadRoutes();

        $request = Request::createFromGlobals();
        $matcher = new UrlMatcher($routes, self::initializeRequestContext($request));

        $dispatcher = self::initializeDispatcher($matcher);

        $kernel = new HttpKernel($dispatcher, new ControllerResolver());
        $response = $kernel->handle($request);
        $response->send();

        $kernel->terminate($request, $response);
    }

    /**
     * Load all routes from config file
     * @return RouteCollection
     */
    public static function loadRoutes()
    {
        $fileLocator = new FileLocator(array(CONFIG_PATH));
        $loader = new YamlFileLoader($fileLocator);
        $routes = $loader->load('routes.yml');
        return $routes;
    }

    /**
     * @param $request
     * @return \Symfony\Component\Routing\RequestContext
     */
    public static function initializeRequestContext(Request $request)
    {
        $requestContext = new \Symfony\Component\Routing\RequestContext();
        $requestContext->fromRequest($request);
        return $requestContext;
    }

    /**
     * @param $matcher
     * @return EventDispatcher
     */
    public static function initializeDispatcher(UrlMatcher $matcher)
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new RouterListener($matcher));
        $dispatcher->addListener(KernelEvents::EXCEPTION, array(new WebsiteExceptionListener(), 'onKernelException'));
        $dispatcher->addListener(KernelEvents::CONTROLLER, array(new WebsiteControllerListener(), 'onKernelController'));
        return $dispatcher;
    }
}