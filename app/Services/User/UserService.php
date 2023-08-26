<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Database\DatabaseService;

class UserService extends DatabaseService implements UserServiceInterface {

    /**
     * @var $table
     */
    private $table = User::TABLE;

    /**
     * Find a user by their username
     *
     * @param string $username The username of the user to find.
     * 
     * @return array|null The user data if found, or null if not found.
     */
    public function findUserByUsername(string $username) : ? array{

        // Query the database to find a user with the given username
        $query = "SELECT * FROM  {$this->table} WHERE username = :username";

        // Prepare the SQL statement
        $stmt = $this->connection->prepare($query);

        // Bind the username parameter to the prepared statement
        $stmt->bindValue(':username', $username, \PDO::PARAM_STR);

        //execute statement
        $stmt->execute();
        
        // Fetch the user data as an associative array
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Return user data if found, otherwise return null
        return $user ?: null;

    }
}

