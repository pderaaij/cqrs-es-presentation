<?php
namespace CESPres\ES\Product\Commands;

use CESPres\ES\Core\Command\Command;

class PriceProductCommand implements Command {

    private $productId;
    private $exclVat;
    private $inclVat;

    function __construct($productId, $exclVat, $inclVat) {
        $this->productId = $productId;
        $this->exclVat = $exclVat;
        $this->inclVat = $inclVat;
    }

    /**
     * @return mixed
     */
    public function getProductId() {
        return $this->productId;
    }

    /**
     * @return mixed
     */
    public function getExclVat() {
        return $this->exclVat;
    }

    /**
     * @return mixed
     */
    public function getInclVat() {
        return $this->inclVat;
    }




}