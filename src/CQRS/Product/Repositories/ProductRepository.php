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
     */
    public function add(Product $product) {
        $query = "INSERT INTO products (internalName, active) VALUES(:name, :active)";
        $queryValues = array(
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