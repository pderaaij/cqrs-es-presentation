<?php
namespace CESPres\NLayer\Product\Services;

use CESPres\Core\Services\Database\Manager;
use CESPres\NLayer\Product\Models\Product;

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
        $productData = $result->fetchArray(SQLITE3_ASSOC);
        
        $product = new Product();
        $product->populate($productData);

        return $product;
    }
}
