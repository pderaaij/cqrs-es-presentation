<?php
namespace CESPres\ES\Product\ReadModel\Model;


use CESPres\NLayer\Core\Entities\BaseEntity;

class Product extends BaseEntity {

    protected $productId;
    protected $internalName;
    protected $active;
    protected $salesPriceExclVat;
    protected $salesPriceInclVat;

    /**
     * @return mixed
     */
    public function getProductId() {
        return $this->productId;
    }

    /**
     * @return mixed
     */
    public function getInternalName() {
        return $this->internalName;
    }

    /**
     * @return mixed
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * @return mixed
     */
    public function getSalesPriceExclVat() {
        return $this->salesPriceExclVat;
    }

    /**
     * @return mixed
     */
    public function getSalesPriceInclVat() {
        return $this->salesPriceInclVat;
    }

}