<?php
namespace CESPres\NLayer\Product\Models;


use CESPres\NLayer\Core\Entities\BaseEntity;

class ProductSalesPrice extends BaseEntity {

    protected $productSalesPriceId;

    protected $productId;

    protected $salesPriceInclVat;

    protected $salesPriceExclVat;

    /**
     * @return mixed
     */
    public function getProductSalesPriceId()
    {
        return $this->productSalesPriceId;
    }

    /**
     * @param mixed $productSalesPriceId
     */
    public function setProductSalesPriceId($productSalesPriceId)
    {
        $this->productSalesPriceId = $productSalesPriceId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getSalesPriceInclVat()
    {
        return $this->salesPriceInclVat;
    }

    /**
     * @param mixed $salesPriceInclVat
     */
    public function setSalesPriceInclVat($salesPriceInclVat)
    {
        $this->salesPriceInclVat = $salesPriceInclVat;
    }

    /**
     * @return mixed
     */
    public function getSalesPriceExclVat()
    {
        return $this->salesPriceExclVat;
    }

    /**
     * @param mixed $salesPriceExclVat
     */
    public function setSalesPriceExclVat($salesPriceExclVat)
    {
        $this->salesPriceExclVat = $salesPriceExclVat;
    }

}