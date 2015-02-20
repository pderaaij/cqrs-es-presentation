<?php
namespace CESPres\CQRS\Product\DomainModel;


use CESPres\NLayer\Core\Entities\BaseEntity;

class ProductView extends BaseEntity {

    protected $productId;

    protected $internalName;

    protected $active;

    protected $name;

    protected $description;

    protected $pros;

    protected $cons;

    protected $salesPriceInclVat;

    protected $salesPriceExclVat;

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
    public function getInternalName()
    {
        return $this->internalName;
    }

    /**
     * @param mixed $internalName
     */
    public function setInternalName($internalName)
    {
        $this->internalName = $internalName;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPros()
    {
        return $this->pros;
    }

    /**
     * @param mixed $pros
     */
    public function setPros($pros)
    {
        $this->pros = $pros;
    }

    /**
     * @return mixed
     */
    public function getCons()
    {
        return $this->cons;
    }

    /**
     * @param mixed $cons
     */
    public function setCons($cons)
    {
        $this->cons = $cons;
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