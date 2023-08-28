<?php

namespace Tests;

use App\Services\Database\DatabaseService;

class TestCase extends DatabaseService
{

    public function refreshDatabase()
    {
        $databaseName = getenv('MYSQL_DATABASE');

        $this->connection->exec('SET FOREIGN_KEY_CHECKS = 0');

        $tablesQuery = $this->connection->prepare("
    SELECT GROUP_CONCAT('DELETE FROM ', table_name, ';') AS delete_queries
    FROM information_schema.tables
    WHERE table_schema = :databaseName
");
        $tablesQuery->bindParam(':databaseName', $databaseName, $this->connection::PARAM_STR);
        $tablesQuery->execute();

        $deleteQueries = $tablesQuery->fetch($this->connection::FETCH_ASSOC)['delete_queries'];

        // Explode the delete queries into an array
        $deleteQueriesArray = explode(',', $deleteQueries);

        // Remove any empty elements and trim whitespace
        $deleteQueriesArray =  array_filter($deleteQueriesArray);

        // Execute each individual delete query
        foreach ($deleteQueriesArray as $deleteQuery) {

            $this->connection->exec($deleteQuery);
        }

        $this->connection->exec('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function db()
    {
        return $this->connection;
    }
}
