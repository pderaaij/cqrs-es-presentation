<?php
namespace CESPres\ES\Product\EventListeners;


use CESPres\ES\Core\DomainModel\DomainMessage;
use CESPres\ES\Core\Eventing\EventListener;
use CESPres\ES\Product\Events\ProductCreatedEvent;

class ProductCreatedEventListener implements EventListener {

    function handle(DomainMessage $message) {
        if (!$message->getEvent() instanceof ProductCreatedEvent) {
            return;
        }

        // @TODO build read model
    }
}