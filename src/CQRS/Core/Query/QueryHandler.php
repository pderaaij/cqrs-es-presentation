<?php
namespace CESPres\CQRS\Core\Query;


interface QueryHandler {
    public function handle(QueryCommand $command);
}