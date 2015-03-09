<?php
namespace CESPres\ES\Product\DomainModel;


/**
 * ProcutSalesPrice is a Value object within the context of a Product. It is not an entity which is meaningful on
 * its own. It always is related to a product.
 *
 * @package CESPres\ES\Product\DomainModel
 */
class ProductSalesPrice {
    private $salesPriceInclVat;
    private $salesPriceExclVat;

    function __construct($salesPriceInclVat, $salesPriceExclVat) {
        $this->salesPriceInclVat = $salesPriceInclVat;
        $this->salesPriceExclVat = $salesPriceExclVat;
    }

}