<?php
namespace CESPres\ES\Product\Repositories;

use CESPres\Core\Registry\Register;
use CESPres\Core\Services\Database\FullAccessManager;
use CESPres\Core\Services\Database\Manager;
use CESPres\ES\Core\DomainModel\AggregateRoot;
use CESPres\ES\Core\DomainModel\DomainMessage;

class EventRepository {

    /**
     * @var Manager
     */
    private $manager;

    function __construct() {
        $this->manager = new FullAccessManager(SQLITE_DB_PATH);
    }

    public function add(AggregateRoot $aggregate) {
        /** @var DomainMessage $message */
        foreach($aggregate->getUncommittedEvents() as $message) {
            $query = "INSERT INTO events (uuid, sequence, payload, recorded_on) VALUES (:uuid, :sequence, :payload, :recorded_on)";
            $queryValues = array(
                'uuid' => $message->getUuid(),
                'sequence' => $message->getSequence(),
                'payload' => json_encode($message->getPayload()),
                'recorded_on' => $message->getRecordedOn()
            );

            $this->manager->insertQuery($query, $queryValues);
            Register::get('event_bus')->publish($message);
        }
    }

    public function findForAggegrateId($uuid) {
        $result = array();
        $query = "select * from events where uuid = '" . $uuid . "'";
        $foundEvents = $this->manager->executeSearchQuery($query);

        // @TODO
        $foundEvents = array($foundEvents);

        foreach($foundEvents as $event) {
            $eventName = 'CESPres\ES\Product\Events\\' . $event['event'] . 'Event';

            if (!class_exists($eventName)) {
                continue;
            }

            $eventObject = new $eventName;
            $eventObject->deserialize($event);
            $result[] = $eventObject;
        }

        return $result;
    }

}