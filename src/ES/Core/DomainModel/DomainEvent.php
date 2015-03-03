<?php
namespace CESPres\ES\Core\DomainModel;


interface DomainEvent {

    function getAggregateId();

    function getPayload();
}