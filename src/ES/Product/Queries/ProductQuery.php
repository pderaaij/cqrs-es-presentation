<?php
namespace CESPres\ES\Product\Queries;
use CESPres\ES\Core\Query\QueryCommand;


/**
 * Query to fetch a single product identified by an identifier
 * @package CESPres\ES\Product\Queries
 */
class ProductQuery implements QueryCommand {

    private $productId;

    public function __construct($productId) {
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