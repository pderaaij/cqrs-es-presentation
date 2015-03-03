<?php
namespace CESPres\CQRS\Product\Repositories;


use CESPres\Core\Services\Database\FullAccessManager;
use CESPres\CQRS\Product\DomainModel\Product;
use Symfony\Component\Config\Definition\Exception\Exception;

class ProductRepository {

    /**
     * @var Manager
     */
    private $databaseManager;

    function __construct()
    {
        $this->databaseManager = new FullAccessManager();
    }

    /**
     * @param Product $product
     * @return int
     */
    public function add(Product $product) {
        $query = "INSERT INTO products (productId, internalName, active) VALUES(:productId, :name, :active)";
        $queryValues = array(
            "productId" => $product->getProductId(),
            "name" => $product->getInternalName(),
            "active" => (int) $product->getActive()
        );

        try {
            $this->databaseManager->insertQuery($query, $queryValues);
        } catch(Exception $e) {
            // log exceptions
        }
    }


}