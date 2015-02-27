<?php
namespace CESPres\CQRS\Product\Repositories;


use CESPres\Core\Exceptions\EntityNotFoundException;
use CESPres\Core\Services\Database\Manager;
use CESPres\Core\Services\Database\ReadManager;
use CESPres\CQRS\Product\DomainModel\ProductView;

class ProductViewRepository {

    private $databaseManager;

    public function __construct() {
        $this->databaseManager = new ReadManager();
    }

    public function get($productId) {
        $productData = $this->databaseManager
            ->executeSearchQuery("select *
                                  from products p
                                  where p.productId = " . $productId
            );

        if($productData === null) {
            throw new EntityNotFoundException("No product found with productId " . $productId);
        }

        $product = new ProductView();
        $product->populate($productData);

        return $product;
    }
}