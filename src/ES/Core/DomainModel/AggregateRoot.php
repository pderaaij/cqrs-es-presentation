<?php
namespace CESPres\ES\Core\DomainModel;


abstract class AggregateRoot {

    /**
     * @var array
     */
    private $uncommittedEvents = array();

    /**
     * @var int
     */
    private $sequence = -1;

    public function apply(DomainEvent $event) {
        $this->uncommittedEvents[] = DomainMessage::record(
            $event->getAggregateId(),
            $this->sequence,
            $event->getPayload()
        );
    }

    /**
     * @return array
     */
    public function getUncommittedEvents() {
        return $this->uncommittedEvents;
    }

}