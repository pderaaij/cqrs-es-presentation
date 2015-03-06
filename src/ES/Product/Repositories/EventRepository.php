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
            $query = "INSERT INTO events (uuid, sequence, payload, recorded_on, event) VALUES (:uuid, :sequence, :payload, :recorded_on, :event)";
            $queryValues = array(
                'uuid' => $message->getUuid(),
                'sequence' => $message->getSequence(),
                'payload' => json_encode($message->getPayload()),
                'recorded_on' => $message->getRecordedOn(),
                'event' =>  (new \ReflectionClass($message->getEvent()))->getShortName()
            );

            $this->manager->insertQuery($query, $queryValues);
            Register::get('event_bus')->publish($message);
        }
    }

    public function load($aggregateId, $clazz) {
        $events = $this->findForAggregateId($aggregateId);

        $aggregate = new $clazz();
        $aggregate->rehydrate($events);

        return $aggregate;
    }

    public function findForAggregateId($uuid) {
        $result = array();
        $query = "select * from events where uuid = '" . $uuid . "' order by sequence";
        $foundEvents = $this->manager->executeSearchQuery($query);

        foreach($foundEvents as $event) {
            $eventName = 'CESPres\ES\Product\Events\\' . $event['event'];

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