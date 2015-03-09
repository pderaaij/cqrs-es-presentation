<?php
namespace CESPres\Core\Services\Database;


class FullAccessManager extends Manager {

    function __construct($databasePath) {
        parent::__construct(new \SQLite3($databasePath));
    }

}