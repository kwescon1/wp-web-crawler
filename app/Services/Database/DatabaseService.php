<?php

namespace App\Services\Database;

use PDO;
use App\Database\Connection;

/**
 * The base service class for database operations.
 */
abstract class DatabaseService implements DatabaseServiceInterface {


	/**
	 * The database connection instance.
	 *
	 * @var PDO
	 */
	protected PDO $connection;

	/**
	 * Constructor to initialize the database connection.
	 */
	public function __construct() {
		 // Get the instance of the database connection using the Connection class.
		$this->connection = Connection::getInstance()->getPdo();
	}


	/**
	 * Retrieves the current database connection instance.
	 *
	 * @return PDO The active PDO database connection.
	 */
	public function getConnection(): PDO {
		return $this->connection;
	}

	/**
	 * Sets the database connection instance.
	 *
	 * @param PDO $connection The PDO database connection to set.
	 */
	public function setConnection( PDO $connection ): void {
		$this->connection = $connection;
	}
}
