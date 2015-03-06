<?php
namespace CESPres\ES\Product\Events;


use CESPres\ES\Core\DomainModel\DomainEvent;

class ProductPublishedEvent implements DomainEvent {

    private $productId;
    private $active;
    private $sequence;

    function __construct($productId = null) {
        $this->productId = $productId;
    }


    function getAggregateId() {
        return $this->productId;
    }

    function getPayload() {
        return array(
            'active' => true
        );
    }

    function deserialize(array $data)
    {
        $this->productId = $data['uuid'];
        $this->active = true;
        $this->sequence = $data['sequence'];
    }

    function getSequence() {
        return $this->sequence;
    }
}