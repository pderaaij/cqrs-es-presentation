<?php
namespace CESPres\NLayer\Product\Services;

use CESPres\Core\Exceptions\EntityNotFoundException;
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
        $productData = $this->databaseManager->executeSearchQuery('select * from products where productId = ' . (int) $productId);

        if($productData === null) {
            throw new EntityNotFoundException("No product found with productId " . $productId);
        }

        $product = new Product();
        $product->populate($productData);

        return $product;
    }
}
