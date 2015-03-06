<?php
namespace CESPres\ES\Core\DomainModel;


use CESPres\ES\Product\Events\ProductCreatedEvent;

abstract class AggregateRoot implements \JsonSerializable {

    /**
     * @var array
     */
    private $uncommittedEvents = array();

    /**
     * @var int
     */
    private $sequence = -1;

    public function apply(DomainEvent $event) {
        $this->sequence++;
        $this->uncommittedEvents[] = DomainMessage::record(
            $event->getAggregateId(),
            $this->sequence,
            $event->getPayload(),
            $event
        );
    }

    public function rehydrate($events) {
        foreach ($events as $event) {
            $name = 'apply' . (new \ReflectionClass($event))->getShortName();

            $this->sequence = $event->getSequence();
            if (method_exists($this, $name)) {
                call_user_func(array($this, $name), $event);
            }
        }
    }

    /**
     * @return array
     */
    public function getUncommittedEvents() {
        return $this->uncommittedEvents;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        $result = array();
        foreach($this as $field => $value) {
            if(!array_key_exists($field, get_class_vars(self::class))) {
                $result[$field] = $this->{$field};
            }
        }

        return $result;
    }
}