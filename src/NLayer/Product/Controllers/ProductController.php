<?php
namespace CESPres\NLayer\Product\Controllers;

use CESPres\Core\Exceptions\PersistenceException;
use CESPres\NLayer\Product\Models\Product;
use CESPres\NLayer\Product\Services\CatalogService;
use Psr\Log\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Product controller.
 *
 * Responsible for viewing and updating a product.
 *
 * @author pderaaij
 */
class ProductController
{
    /**
     * Display product information of the given product id.
     *
     * @param $productId
     * @return Response
     * @throws \CESPres\Core\Exceptions\EntityNotFoundException
     */
    public function get($productId) {
        if(!is_numeric($productId)) {
            throw new BadRequestHttpException("Invalid product id given");
        }
        
        $catalogQueryService = new CatalogService();
        $product = $catalogQueryService->findProductById($productId);

        $response = new Response(json_encode($product), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    /**
     * Update the given product id with the new product information.
     *
     * @param Request $request
     * @return Response
     * @throws \CESPres\Core\Exceptions\EntityNotFoundException
     */
    public function post(Request $request) {
        $requestBody = json_decode($request->getContent());
        $productId = $request->get('productId');

        if(empty($productId) || $productId !== $requestBody->productId) {
            throw new InvalidArgumentException("ProductId does not match with the entered body");
        }

        $catalogService = new CatalogService();
        $product = $catalogService->findProductById($productId);
        $product->populate($requestBody);
        $catalogService->updateProduct($product);

        $response = new Response(null, Response::HTTP_NO_CONTENT);
        return $response;
    }

    /**
     * Add a new product to the catalog.
     *
     * @param Request $request
     * @return Response
     * @throws \CESPres\Core\Exceptions\EntityNotFoundException
     */
    public function put(Request $request) {
        $requestBody = json_decode($request->getContent());

        $catalogService = new CatalogService();
        $product = new Product();
        $product->populate($requestBody);
        $insertedProductId = $catalogService->insertProduct($product);

        $newProduct = $catalogService->findProductById($insertedProductId);
        $response = new Response(json_encode($newProduct), Response::HTTP_CREATED);
        return $response;
    }
}
