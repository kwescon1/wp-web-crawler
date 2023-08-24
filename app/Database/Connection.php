<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    // Hold the single instance of the Connection class
    private static $instance = null;

    // PDO instance for database interaction
    private PDO $pdo;

    // Character encoding for the database connection
    private string $charset = 'utf8mb4';

    // PDO options for configuring behavior
    private const OPTIONS = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // Private constructor to prevent direct instantiation
    private function __construct()
    {
        // Create a connection string to connect to the database using environment variables
        $connectionString = "mysql:host={$_ENV['MYSQL_HOST']};dbname={$_ENV['MYSQL_DATABASE']};port={$_ENV['MYSQL_PORT']}";

        try {
            // Establish a PDO connection using the connection string, username, and password
            $this->pdo = new PDO($connectionString, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], self::OPTIONS);
        } catch (PDOException $exception) {
            // If a connection error occurs, throw a PDOException
            throw new PDOException($exception->getMessage(), (int) $exception->getCode());
        }
    }

    // Get a single instance of the Connection class
    public static function getInstance(): self
    {
        // If no instance exists, create one
        if (self::$instance === null) {
            self::$instance = new self();
        }

        // Return the instance
        return self::$instance;
    }

    // Get the PDO instance for database operations
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
