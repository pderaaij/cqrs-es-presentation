<?php
namespace CESPres\CQRS\Product\Queries;
use CESPres\CQRS\Core\Query\QueryCommand;


/**
 * Query to fetch a single product identified by an identifier
 * @package CESPres\CQRS\Product\Queries
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