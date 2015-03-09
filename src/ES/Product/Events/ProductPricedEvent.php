<?php
namespace CESPres\ES\Product\Events;


use CESPres\ES\Core\DomainModel\DomainEvent;

class ProductPricedEvent implements DomainEvent {

    private $productId;
    private $exclVat;
    private $inclVat;

    private $sequence;

    function __construct($productId = null, $exclVat = null, $inclVat = null) {
        $this->productId = $productId;
        $this->exclVat = $exclVat;
        $this->inclVat = $inclVat;
    }


    function getAggregateId() {
        return $this->productId;
    }

    function getPayload() {
        return array(
            "salesPriceExclVat" => $this->exclVat,
            "salesPriceInclVat" => $this->inclVat
        );
    }

    function getSequence() {
        return $this->sequence;
    }

    function deserialize(array $data) {
        $this->productId = $data['uuid'];
        $this->sequence = $data['sequence'];

        $payload = json_decode($data['payload']);
        $this->exclVat = $payload->salesPriceExclVat;
        $this->inclVat = $payload->salesPriceInclVat;
    }
}