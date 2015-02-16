<?php
namespace CESPres\Product\Services;

/**
 * Description of CatalogQuery
 *
 * @author pderaaij
 */
class CatalogQuery
{
    public function findProductById($productId) {
        $product = new \CESPres\Product\Models\Product();
        $product->setProductId($productId);
        $product->setName('Test product');
        $product->setSalesPrice(9.99);
        
        return $product;
    }
}
