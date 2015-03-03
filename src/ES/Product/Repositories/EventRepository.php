<?php
namespace CESPres\ES\Product\Repositories;


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
        }
    }

}