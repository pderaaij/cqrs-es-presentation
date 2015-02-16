<?php
namespace CESPres\Services\Database;

/**
 * Description of Manager
 *
 * @author pderaaij
 */
class Manager
{
    
    private $sqliteConnection;
    
    public function __construct() {
        /**
         * @todo Change path, inject database
         */
        $this->sqliteConnection = new \SQLite3("/var/www/cqrs-es-presentation/cqrs-es-db.sqlite");
    }
    
    public function executeQuery($query) {
        return $this->sqliteConnection->query($query);
    }
}
