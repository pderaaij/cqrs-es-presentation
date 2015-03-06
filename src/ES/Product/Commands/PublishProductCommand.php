<?php
namespace CESPres\ES\Product\Commands;

use CESPres\ES\Core\Command\Command;

/**
 * Class PublishProductCommand
 * @package CESPres\ES\Product\Commands
 */
class PublishProductCommand implements Command {

    private $productId;

    function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

}