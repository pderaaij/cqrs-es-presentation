<?php
namespace CESPres\ES\Core\Eventing;


use CESPres\ES\Core\DomainModel\DomainMessage;

interface EventListener {
    function handle(DomainMessage $message);
}