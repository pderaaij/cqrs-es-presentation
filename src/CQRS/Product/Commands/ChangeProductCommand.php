<?php
namespace CESPres\CQRS\Product\Commands;


class ChangeProductCommand {

    private $productId;

    private $alterations;

    public function __construct($productId, $productAlterations) {
        $this->productId = $productId;
        $this->alterations = $productAlterations;
    }
}