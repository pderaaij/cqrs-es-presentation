<?php
namespace CESPres\Product\Services;

use \CESPres\Services\Database\Manager;

/**
 * Description of CatalogQuery
 *
 * @author pderaaij
 */
class CatalogQuery
{
    
    private $databaseManager;
    
    public function __construct() {
        $this->databaseManager = new Manager();
    }
    
    public function findProductById($productId) {
        /**
         * @todo A LOT
         */
        $result = $this->databaseManager->executeQuery('select * from products where productId = ' . $productId);
        $productData = $result->fetchArray();
        
        $product = new \CESPres\Product\Models\Product();
        $product->setProductId($productData['productId']);
        $product->setName($productData['name']);
        $product->setDescription($productData['description']);
        $product->setSalesPrice($productData['salesPrice']);
        
        return $product;
    }
}
