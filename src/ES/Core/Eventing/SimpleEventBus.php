<?php
namespace CESPres\ES\Core\Eventing;


use CESPres\ES\Core\DomainModel\DomainMessage;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * A simple in-memory event bus. This can also be done via messaging mechanisms like RabbitMQ or even a persistent
 * database which acts as a queue.
 *
 * @package CESPres\ES\Core\Eventing
 */
class SimpleEventBus {
    private $listeners = array();
    private $queue = array();

    /**
     * @param EventListener $listener
     */
    public function subscribe(EventListener $listener) {
        $this->listeners[] = $listener;
    }

    /**
     * Publish a message to all registered event listeners.
     *
     * @param DomainMessage $message
     */
    public function publish(DomainMessage $message) {
        $this->queue[] = $message;

        try {
            while($message = array_shift($this->queue)) {
                foreach($this->listeners as $listener) {
                    $listener->handle($message);
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}