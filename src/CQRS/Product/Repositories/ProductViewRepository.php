<?php
namespace CESPres\CQRS\Product\Repositories;


use CESPres\Core\Exceptions\EntityNotFoundException;
use CESPres\Core\Services\Database\ReadManager;
use CESPres\CQRS\Product\DomainModel\Product;
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
                                  where p.productId = '" . $productId . "'");

        if($productData === null) {
            throw new EntityNotFoundException("No product found with productId " . $productId);
        }

        $product = new ProductView();
        $product->populate($productData);

        return $product;
    }

    /**
     * Synchronize product to read database
     * @param Product $product
     * @return Product
     */
    public function sync(Product $product) {
        $existsQuery = "select * from products p where p.productId = '" . $product->getProductId() . "'";
        $exists = (null !== $this->databaseManager->executeSearchQuery($existsQuery));
        
        $values = array(
            'productId' => $product->getProductId(),
            'internalName' => $product->getInternalName(),
            'active' => $product->getActive()
        );

        if (!$exists) {
            $query = "insert into products (productId, internalName,active) "
                    . "values (:productId, :internalName, :active)";
            $this->databaseManager->insertQuery($query, $values);
        } else {
            $query = "update products set"
                    . "internalName = :internalName,"
                    . "active = :active "
                    . "where productId = :productId";
            $this->databaseManager->updateQuery($query, $values);
        }
        return $product;
    }
}