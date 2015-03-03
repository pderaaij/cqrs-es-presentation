<?php
namespace CESPres\ES\Core\DomainModel;


final class DomainMessage {

    private $uuid;

    private $sequence;

    private $payload;

    private $recordedOn;

    public function __construct($uuid, $sequence, $payload, $recordedOn) {
        $this->uuid = $uuid;
        $this->sequence = $sequence;
        $this->payload = $payload;
        $this->recordedOn = $recordedOn;
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

    public static function record($uuid, $sequence, $payload) {
        return new DomainMessage($uuid, $sequence, $payload, date("Y-m-d H:i:s"));
    }

}