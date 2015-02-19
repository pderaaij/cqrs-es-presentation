<?php
namespace CESPres\Core\Services\Database;

/**
 * Description of Manager
 *
 * @author pderaaij
 */
class Manager
{
    
    private $sqliteConnection;
    
    public function __construct() {
        $this->sqliteConnection = new \SQLite3(SQLITE_DB_PATH);
        $this->sqliteConnection->enableExceptions(true);
    }

    /**
     * @param $query
     * @return array|null
     */
    public function executeSearchQuery($query) {
        $queryResult = $this->sqliteConnection->query($query);
        $resultSet = $queryResult->fetchArray(SQLITE3_ASSOC);

        if ($resultSet !== false) {
            return $resultSet;
        }

        return null;
    }
}
