<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection {


	// Hold the single instance of the Connection class
	private static $instance = null;

	// PDO instance for database interaction
	private PDO $pdo;

	// Character encoding for the database connection
	private string $charset = 'utf8mb4';

	// PDO options for configuring behavior
	private const OPTIONS = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	];

	// Private constructor to prevent direct instantiation
	private function __construct() {
		// Get the configuration values from the included file
		$config = require_once __DIR__ . '/../../config/database.php';

		// Create a connection string to connect to the database using environment variables
		$connectionString = "mysql:host={$config['db_host']};dbname={$config['db_name']};port={$config['db_port']}";

		try {
			// Establish a PDO connection using the connection, username, and password
			$this->pdo = new PDO( $connectionString, $config['db_user'], $config['db_password'], self::OPTIONS );

			// Set the character encoding for the connection
			$this->pdo->exec( "SET NAMES '{$this->charset}'" );

		} catch ( PDOException $exception ) {
			// If a connection error occurs, throw a PDOException
			throw new PDOException( $exception->getMessage(), (int) $exception->getCode() );
		}
	}

	// Get a single instance of the Connection class
	public static function getInstance(): self {
		// If no instance exists, create one
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		// Return the instance
		return self::$instance;
	}

	// Get the PDO instance for database operations
	public function getPdo(): PDO {
		return $this->pdo;
	}
}
