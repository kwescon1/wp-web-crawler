<?php

namespace App\Services\Database;

use PDO;
use App\Database\Connection;

/**
 * The base service class for database operations.
 */
abstract class DatabaseService implements DatabaseServiceInterface
{

	/**
	 * The database connection instance.
	 *
	 * @var PDO
	 */
	protected PDO $connection;

	/**
	 * Constructor to initialize the database connection.
	 */
	public function __construct()
	{
		// Get the instance of the database connection using the Connection class.
		$this->connection = Connection::getInstance()->getPdo();
	}
}
