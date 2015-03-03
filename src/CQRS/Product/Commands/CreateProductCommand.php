<?php
namespace CESPres\CQRS\Product\Commands;


use CESPres\CQRS\Core\Command\Command;

class CreateProductCommand implements Command {

    private $internalName;

    private $productId;

    function __construct($internalName, $productId)
    {
        $this->internalName = $internalName;
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
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

}