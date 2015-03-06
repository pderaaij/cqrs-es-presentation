<?php
namespace CESPres\ES\Product\DomainModel;


use CESPres\ES\Core\DomainModel\AggregateRoot;
use CESPres\ES\Product\Events\ProductCreatedEvent;
use CESPres\ES\Product\Events\ProductPublishedEvent;

class Product extends AggregateRoot {

    protected $productId;

    protected $internalName;

    protected $active;

    /**
     * Create a new product.
     *
     * @param $productId
     * @param $internalName
     * @param $active
     * @return Product
     */
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

    /**
     * Publish a product so it becomes active
     */
    public function publish() {
        if (!$this->active) {
            $this->apply(
                new ProductPublishedEvent($this->productId)
            );
        }
    }

    /**
     * Apply the product create event.
     * @param ProductCreatedEvent $event
     */
    public function applyProductCreatedEvent(ProductCreatedEvent $event) {
        $payload = $event->getPayload();

        $this->productId = $event->getAggregateId();
        $this->internalName = $payload['internalName'];
        $this->active = $payload['active'];
    }

    /**
     * @param ProductPublishedEvent $event
     */
    public function applyProductPublishedEvent(ProductPublishedEvent $event) {
        $this->active = true;
    }

}