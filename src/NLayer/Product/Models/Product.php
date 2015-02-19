<?php
namespace CESPres\NLayer\Product\Models;
use CESPres\NLayer\Core\Entities\BaseEntity;

/**
 * Product entity used in the catalog.
 *
 * @author pderaaij
 */
class Product extends BaseEntity
{
    protected $productId;

    protected $internalName;

    protected $active;

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

}
