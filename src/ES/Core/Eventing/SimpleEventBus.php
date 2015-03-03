<?php
namespace CESPres\ES\Core\Eventing;


use CESPres\ES\Core\DomainModel\DomainMessage;
use Symfony\Component\Config\Definition\Exception\Exception;

class SimpleEventBus {
    private $listeners = array();
    private $queue = array();

    public function subscribe(EventListener $listener) {
        $this->listeners[] = $listener;
    }

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