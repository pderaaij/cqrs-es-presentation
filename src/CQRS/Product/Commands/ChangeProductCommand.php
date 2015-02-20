<?php
namespace CESPres\CQRS\Product\Commands;


use CESPres\CQRS\Product\DomainModel\Product;

class ChangeProductCommand {

    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

}