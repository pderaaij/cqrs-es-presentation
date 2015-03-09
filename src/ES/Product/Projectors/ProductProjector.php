<?php
namespace CESPres\ES\Product\Projectors;


use CESPres\ES\Core\DomainModel\DomainMessage;
use CESPres\ES\Core\Projectors\Projector;
use CESPres\ES\Product\Events\ProductCreatedEvent;
use CESPres\ES\Product\Events\ProductPricedEvent;
use CESPres\ES\Product\Events\ProductPublishedEvent;
use CESPres\ES\Product\ReadModel\Model\Product;
use CESPres\ES\Product\ReadModel\Repositories\ProductRepository;
use CESPres\ES\Product\Repositories\EventRepository;

class ProductProjector implements Projector {

    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var ProductRepository
     */
    private $productReadRepository;

    public function __construct() {
        $this->eventRepository = new EventRepository();
        $this->productReadRepository = new ProductRepository();
    }

    function handle(DomainMessage $message) {
        if (!$this->messageIsApplicable($message)) {
            $this->applyMessage($message);
        }
    }

    /**
     * @param DomainMessage $message
     * @return bool
     */
    private function messageIsApplicable(DomainMessage $message) {
        return (
            $message instanceof ProductCreatedEvent ||
            $message instanceof ProductPricedEvent ||
            $message instanceof ProductPublishedEvent
        );
    }

    private function applyMessage(DomainMessage $message) {
        $methodName = 'apply' . (new \ReflectionClass($message->getEvent()))->getShortName();

        if (method_exists($this, $methodName)) {
            $this->{$methodName}($message);
        }
    }

    private function applyProductCreatedEvent(DomainMessage $message) {
        $payload = $message->getPayload();
        $payload['productId'] = $message->getUuid();

        $product = new Product();
        $product->populate($payload);

        $this->productReadRepository->save($product);
    }

    private function applyProductPublishedEvent(DomainMessage $message) {
        $product = $this->productReadRepository->find($message->getUuid());

        if(!$product) {
            // Log error and break execution
            return;
        }

        $product->populate($message->getPayload());

        $this->productReadRepository->save($product);
    }

    private function applyProductPricedEvent(DomainMessage $message) {
        $product = $this->productReadRepository->find($message->getUuid());

        if(!$product) {
            // Log error and break execution
            return;
        }

        $product->populate($message->getPayload());

        $this->productReadRepository->save($product);
    }

}