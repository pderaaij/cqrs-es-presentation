<?php
namespace CESPres\NLayer\Product\Controllers;

use CESPres\NLayer\Product\Services\CatalogQuery;
use \Symfony\Component\HttpFoundation\Response;

/**
 * Basic Product controller
 *
 * @author pderaaij
 */
class ProductController
{
    public function index($productId) {
        
        if(!is_numeric($productId)) {
            return new Response("Invalid product id given", Response::HTTP_BAD_REQUEST);
        }
        
        $catalogQueryService = new CatalogQuery();
        $product = $catalogQueryService->findProductById($productId);

        $response = new Response(json_encode($product), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
