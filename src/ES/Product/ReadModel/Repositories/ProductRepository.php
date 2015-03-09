<?php
namespace CESPres\ES\Product\ReadModel\Repositories;


use CESPres\Core\Services\Database\FullAccessManager;
use CESPres\Core\Services\Database\Manager;
use CESPres\ES\Product\ReadModel\Model\Product;

class ProductRepository {

    /**
     * @var Manager
     */
    private $manager;

    function __construct() {
        $this->manager = new FullAccessManager(SQLITE_PROJECTION_STORE_PATH);
    }

    public function find($id) {
        $searchQuery = "SELECT * FROM products p WHERE p.productId = '" . $id . "'";
        $productData = $this->manager->executeSearchQuery($searchQuery);

        if ($productData === null) {
            return null;
        }

        $product =  new Product();
        $product->populate($productData[0]);
        return $product;
    }

    public function save(Product $product) {
        if (null === $this->find($product->getProductId())) {
            $insertQuery = "INSERT INTO products(productId, internalName, active, salesPriceInclVat, salesPriceExclVat)
                            VALUES (:productId, :internalName, :active, :salesPriceInclVat, :salesPriceExclVat)";

            $queryValues = array (
                "productId" => $product->getProductId(),
                "internalName" => $product->getInternalName(),
                "active" => $product->getActive(),
                "salesPriceInclVat" => $product->getSalesPriceInclVat(),
                "salesPriceExclVat" => $product->getSalesPriceExclVat()
            );

            $this->manager->insertQuery($insertQuery, $queryValues);
        } else {
            $updateQuery = "UPDATE products SET
                           internalName = '" . $product->getInternalName() . "',
                           active = '" . $product->getActive() . "',
                           salesPriceExclVat = '" . $product->getSalesPriceExclVat() . "',
                           salesPriceInclVat = '" . $product->getSalesPriceInclVat() . "'
                           where productId = '" .  $product->getProductId() . "'";

            $queryValues = array (
                "productId" => $product->getProductId(),
                "internalName" => $product->getInternalName(),
                "active" => $product->getActive(),
                "salesPriceInclVat" => $product->getSalesPriceInclVat(),
                "salesPriceExclVat" => $product->getSalesPriceExclVat()
            );

            $this->manager->updateQuery($updateQuery, $queryValues);
        }
    }

}