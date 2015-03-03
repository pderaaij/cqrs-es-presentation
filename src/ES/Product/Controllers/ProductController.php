<?php
namespace CESPres\ES\Product\Controllers;


use CESPres\Core\Generators\GUID;
use CESPres\Core\Registry\Register;
use CESPres\ES\Product\Commands\CreateProductCommand;
use CESPres\ES\Product\DomainModel\Product;
use CESPres\ES\Product\Queries\ProductQuery;
use CESPres\ES\Product\Repositories\ProductRepository;
use InvalidArgumentException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductController {

    public function get($productId) {

        if(empty($productId)) {
            throw new BadRequestHttpException("Invalid product id given");
        }

        $repo = new ProductRepository();
        $product = $repo->find($productId);

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
            $productId = GUID::generate();
            $createProductCommand = new CreateProductCommand($requestBody->internalName, $productId);
            Register::get('command_bus')->handle($createProductCommand);

            $response = new RedirectResponse("/es/product/" . $productId);
        } catch(Exception $e) {
            $response = new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $response;
    }
}