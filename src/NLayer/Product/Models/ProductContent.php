<?php
namespace CESPres\NLayer\Product\Models;


use CESPres\NLayer\Core\Entities\BaseEntity;

class ProductContent extends BaseEntity {

    protected $productContentId;

    protected $productId;

    protected $name;

    protected $description;

    protected $pros;

    protected $cons;

    /**
     * @return mixed
     */
    public function getProductContentId()
    {
        return $this->productContentId;
    }

    /**
     * @param mixed $productContentId
     */
    public function setProductContentId($productContentId)
    {
        $this->productContentId = $productContentId;
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


}