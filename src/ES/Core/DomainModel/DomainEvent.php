<?php
namespace CESPres\ES\Core\DomainModel;


interface DomainEvent {

    function getAggregateId();

    function getPayload();

    function getSequence();

    function deserialize(array $data);
}