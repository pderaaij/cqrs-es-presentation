<?php
namespace CESPres\ES\Product\Events;


use CESPres\ES\Core\DomainModel\DomainEvent;

class ProductCreatedEvent implements DomainEvent {

    private $productId;
    private $internalName;
    private $active;

    function __construct($productId = null, $internalName = null, $active = null) {
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

    function deserialize(array $data)
    {
        $this->productId = $data['uuid'];
        $payload = json_decode($data['payload']);
        $this->internalName = $payload->internalName;
        $this->active = $payload->active;
    }
}