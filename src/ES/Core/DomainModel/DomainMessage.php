<?php
namespace CESPres\ES\Core\DomainModel;


final class DomainMessage {

    private $uuid;

    private $sequence;

    private $payload;

    private $recordedOn;

    /**
     * @var DomainEvent
     */
    private $event;

    public function __construct($uuid, $sequence, $payload, $recordedOn, DomainEvent $event) {
        $this->uuid = $uuid;
        $this->sequence = $sequence;
        $this->payload = $payload;
        $this->recordedOn = $recordedOn;
        $this->event = $event;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return mixed
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return mixed
     */
    public function getRecordedOn()
    {
        return $this->recordedOn;
    }

    /**
     * @return DomainEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

    public static function record($uuid, $sequence, $payload, DomainEvent $event) {
        return new DomainMessage($uuid, $sequence, $payload, date("Y-m-d H:i:s"), $event);
    }

}