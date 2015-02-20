<?php
namespace CESPres\Core\Exceptions;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class QueryHandlerNotFoundException extends \Exception implements HttpExceptionInterface {

    /**
     * Returns the status code.
     *
     * @return int An HTTP response status code
     */
    public function getStatusCode()
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * Returns response headers.
     *
     * @return array Response headers
     */
    public function getHeaders()
    {
        return array();
    }
}