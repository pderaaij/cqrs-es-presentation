<?php
namespace CESPres\Core\Services\Database;

/**
 * Database manager exposing generic query methods for the connected database.
 *
 * @author pderaaij
 */
abstract class Manager
{
    
    private $sqliteConnection;
    
    public function __construct(\SQLite3 $connection) {
        $this->sqliteConnection = $connection;
        $this->sqliteConnection->enableExceptions(true);
    }

    /**
     * Execute a select query on the database.
     *
     * @param $query
     * @return array|null
     */
    public function executeSearchQuery($query) {
        $queryResult = $this->sqliteConnection->query($query);
        $resultSet = array();

        while($result = $queryResult->fetchArray(SQLITE3_ASSOC)) {
            $resultSet[] = $result;
        }

        if (count($resultSet) === 0) {
            return null;
        }

        return $resultSet;
    }

    /**
     * Execute update queries on the database.
     *
     * @param $query
     * @param array $queryValues
     */
    public function updateQuery($query, array $queryValues) {
        $statement = $this->sqliteConnection->prepare($query);

        foreach($queryValues as $field => $value) {
            $statement->bindValue(':'.$field, $this->sqliteConnection->escapeString($value));
        }

       $statement->execute();
    }

    /**
     * Execute an insert query on the database, returning the new identifier.
     *
     * @param $query
     * @param array $queryValues
     * @return int
     */
    public function insertQuery($query, array $queryValues) {
        $statement = $this->sqliteConnection->prepare($query);

        foreach($queryValues as $field => $value) {
            $statement->bindValue(':'.$field, $this->sqliteConnection->escapeString($value));
        }

        $statement->execute();
        return $this->sqliteConnection->lastInsertRowID();
    }
}
