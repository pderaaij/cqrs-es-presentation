<?php
namespace CESPres\Product\Models;

/**
 * Representation of a Product
 *
 * @author pderaaij
 */
class Product
{
    public $productId;
    
    public $name;
    
    public $description;
    
    public $salesPrice;
    
    public function getProductId()
    {
        return $this->productId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSalesPrice()
    {
        return $this->salesPrice;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setSalesPrice($salesPrice)
    {
        $this->salesPrice = $salesPrice;
    }
}
