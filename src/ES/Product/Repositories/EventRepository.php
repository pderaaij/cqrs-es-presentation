<?php
namespace CESPres\ES\Product\Repositories;

use CESPres\Core\Registry\Register;
use CESPres\Core\Services\Database\FullAccessManager;
use CESPres\Core\Services\Database\Manager;
use CESPres\ES\Core\DomainModel\AggregateRoot;
use CESPres\ES\Core\DomainModel\DomainMessage;

/**
 * Repository for all event actions.
 *
 * @package CESPres\ES\Product\Repositories
 */
class EventRepository {

    /**
     * @var Manager
     */
    private $manager;

    function __construct() {
        $this->manager = new FullAccessManager(SQLITE_DB_PATH);
    }

    /**
     * @param AggregateRoot $aggregate
     */
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

    /**
     * Load the given aggregate with event state.
     *
     * @param $aggregateId
     * @param $clazz
     * @return mixed
     */
    public function load($aggregateId, $clazz) {
        $events = $this->findForAggregateId($aggregateId);

        /** @var AggregateRoot $aggregate */
        $aggregate = new $clazz();
        $aggregate->rehydrate($events);

        return $aggregate;
    }

    /**
     * Find all events for the given aggregate identifier.
     *
     * @param $uuid
     * @return array
     */
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