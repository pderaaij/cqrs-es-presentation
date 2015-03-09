<?php
namespace CESPres\ES\Product\Controllers;


use CESPres\Core\Registry\Register;
use CESPres\ES\Product\Commands\PriceProductCommand;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductSalesPriceController {

    public function post($productId, Request $request) {
        $requestBody = json_decode($request->getContent());

        if(empty($productId)) {
            throw new BadRequestHttpException("Invalid product id given");
        }

        if ($productId !== $requestBody->productId) {
            throw new BadRequestHttpException("Invalid body given");
        }

        try {
            $publishProductCommand = new PriceProductCommand($productId, $requestBody->exclVat, $requestBody->inclVat);
            Register::get('command_bus')->handle($publishProductCommand);

            $response = new RedirectResponse("/es/product/" . $productId);
        } catch(\Exception $e) {
            $response = new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }
}