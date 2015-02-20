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
class CatalogService
{
    
    private $databaseManager;
    
    public function __construct() {
        $this->databaseManager = new Manager();
    }

    /**
     * @param $productId
     * @return Product
     * @throws EntityNotFoundException
     */
    public function findProductById($productId) {
        $productData = $this->databaseManager
            ->executeSearchQuery("select *
                                  from products p
                                  join products_content pc ON p.productId = pc.productId
                                  join products_sales_price psc ON p.productId = psc.productId
                                  where p.productId = " . $productId
            );

        if($productData === null) {
            throw new EntityNotFoundException("No product found with productId " . $productId);
        }

        $product = new Product();
        $product->populate($productData);

        return $product;
    }

    public function updateProduct(Product $product) {
        $query = "update products SET internalName = :name, active = :active where productId = :productId";
        $queryValues = array(
            "name" => $product->getInternalName(),
            "active" => $product->getActive(),
            "productId" => $product->getProductId()
        );

        $this->databaseManager->updateQuery($query, $queryValues);
    }
}
