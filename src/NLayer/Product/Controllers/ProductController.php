<?php
namespace CESPres\NLayer\Product\Controllers;

use CESPres\NLayer\Product\Services\CatalogQuery;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Basic Product controller
 *
 * @author pderaaij
 */
class ProductController
{
    public function index($productId) {
        
        if(!is_numeric($productId)) {
            throw new BadRequestHttpException("Invalid product id given");
        }
        
        $catalogQueryService = new CatalogQuery();
        $product = $catalogQueryService->findProductById($productId);

        $response = new Response(json_encode($product), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
