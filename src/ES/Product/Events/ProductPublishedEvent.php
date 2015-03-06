<?php
namespace CESPres\ES\Product\Events;

use CESPres\ES\Core\DomainModel\DomainEvent;

/**
 * Class ProductPublishedEvent
 * @package CESPres\ES\Product\Events
 */
class ProductPublishedEvent implements DomainEvent {

    private $productId;
    private $sequence;

    function __construct($productId = null) {
        $this->productId = $productId;
    }


    function getAggregateId() {
        return $this->productId;
    }

    function getPayload() {
        return array();
    }

    function deserialize(array $data)
    {
        $this->productId = $data['uuid'];
        $this->sequence = $data['sequence'];
    }

    function getSequence() {
        return $this->sequence;
    }
}