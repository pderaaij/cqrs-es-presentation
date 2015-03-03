<?php
namespace CESPres\ES\Product\Events;


use CESPres\ES\Core\DomainModel\DomainEvent;

class ProductCreatedEvent implements DomainEvent {

    private $productId;
    private $internalName;
    private $active;

    function __construct($productId, $internalName, $active) {
        $this->productId = $productId;
        $this->internalName = $internalName;
        $this->active = $active;
    }


    function getAggregateId() {
        return $this->productId;
    }

    function getPayload() {
        return array(
            "active" => $this->active,
            "internalName" => $this->internalName
        );
    }
}