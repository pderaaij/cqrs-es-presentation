<?php
namespace CESPres\Website\Listeners;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WebsiteControllerListener {

    /**
     * When we get a POST or PUT request we only allow JSON bodies to be given. All other stuff, just reject.
     *
     * @param FilterControllerEvent $event
     * @throws BadRequestHttpException
     */
    public function onKernelController(FilterControllerEvent $event) {
        $request = $event->getRequest();

        if ($request->getMethod() === Request::METHOD_POST || $request->getMethod() === Request::METHOD_PUT) {
            $rawRequestBody =  $request->getContent();

            if($rawRequestBody === "") {
                throw new BadRequestHttpException("Empty body is not allowed");
            }

            try {
                $parsedBody = json_decode($rawRequestBody);
            } catch(\Exception $e) {
                throw new BadRequestHttpException("Not a valid request body given. JSON expected");
            }

            if(!is_object($parsedBody)) {
                throw new BadRequestHttpException("Not a valid request body given. JSON expected");
            }
        }
    }
}