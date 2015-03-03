<?php
namespace CESPres\ES\Product\DomainModel;


use CESPres\ES\Core\DomainModel\AggregateRoot;
use CESPres\ES\Product\Events\ProductCreatedEvent;

class Product extends AggregateRoot {

    protected $productId;

    protected $internalName;

    protected $active;

    public static function create($productId, $internalName, $active) {

        if (empty($internalName)) {
            throw new \InvalidArgumentException("Name is mandatory");
        }

        $product = new self();

        $product->apply(
          new ProductCreatedEvent($productId, $internalName, $active)
        );

        return $product;
    }


}