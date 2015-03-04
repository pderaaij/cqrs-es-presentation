<?php
namespace CESPres\ES\Core\DomainModel;


interface DomainEvent {

    function getAggregateId();

    function getPayload();

    function deserialize(array $data);
}