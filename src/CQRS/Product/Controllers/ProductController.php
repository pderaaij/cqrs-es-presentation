<?php
namespace CESPres\CQRS\Product\Controllers;


use CESPres\Core\Registry\Register;
use CESPres\CQRS\Product\Commands\CreateProductCommand;
use CESPres\CQRS\Product\Queries\ProductQuery;
use InvalidArgumentException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController {

    public function get($productId) {

        if(!is_numeric($productId)) {
            throw new BadRequestHttpException("Invalid product id given");
        }

        $productQuery = new ProductQuery($productId);
        $product = Register::get('query_bus')->handle($productQuery);

        $response = new Response(json_encode($product), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    
    /**
     * Method used to create a new product displaying immediate consistency.
     * 
     * @param Request $request
     * @return Response
     * @throws InvalidArgumentException
     */
    public function post(Request $request) {
        $requestBody = json_decode($request->getContent());

        if(empty($requestBody) || empty($requestBody->internalName)) {
            throw new InvalidArgumentException("Missing required data for creating a Product");
        }

        try {
            $createProductCommand = new CreateProductCommand($requestBody->internalName);
            Register::get('command_bus')->handle($createProductCommand);

            $response = new Response(null, Response::HTTP_NO_CONTENT);
        } catch(Exception $e) {
            $response = new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $response;
    }
}