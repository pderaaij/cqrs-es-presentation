<?php
namespace CESPres\ES\Product\Controllers;


use CESPres\Core\Generators\GUID;
use CESPres\Core\Registry\Register;
use CESPres\ES\Product\Commands\CreateProductCommand;
use CESPres\ES\Product\Commands\PublishProductCommand;
use CESPres\ES\Product\ReadModel\Repositories\ProductRepository;
use InvalidArgumentException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductController {

    /**
     * Fetch a product using re-hydration mechanism. This means we fetch the aggregate events
     * and replay that for each retrieval.
     *
     * @param $productId
     * @return Response
     */
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

    /**
     * @param $productId
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function publish($productId, Request $request) {
        $requestBody = json_decode($request->getContent());

        if(empty($productId)) {
            throw new BadRequestHttpException("Invalid product id given");
        }

        if ($productId !== $requestBody->productId) {
            throw new BadRequestHttpException("Invalid body given");
        }

        try {
            $publishProductCommand = new PublishProductCommand($productId);
            Register::get('command_bus')->handle($publishProductCommand);

            $response = new RedirectResponse("/es/product/" . $productId);
        } catch(Exception $e) {
            $response = new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }
}