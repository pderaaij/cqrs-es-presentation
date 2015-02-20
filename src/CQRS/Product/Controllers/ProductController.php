<?php
namespace CESPres\CQRS\Product\Controllers;


use CESPres\Core\Registry\Register;
use CESPres\CQRS\Product\Queries\ProductQuery;
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
}