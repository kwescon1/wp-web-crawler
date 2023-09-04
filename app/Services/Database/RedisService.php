<?php

namespace App\Services\Database;

use Predis\Client;
use App\Database\Redis;
use Predis\Response\Status;

/**
 * The base service class for redis operations.
 */
class RedisService implements RedisServiceInterface {


	/**
	 * The redis connection instance.
	 *
	 * @var Client
	 */
	protected Client $connection;

	/**
	 * Constructor to initialize the redis connection.
	 */
	public function __construct() {
		// Get the instance of the database connection using the Connection class.
		$this->connection = Redis::getInstance()->getClient();
	}

	/**
	 * Set a key-value pair in Redis.
	 *
	 * @param string $key
	 * @param bool   $value
	 * @param int    $seconds
	 * @return Predis\Response\Status
	 */
	public function setKeyValue( string $key, int $seconds, bool $value ): Status {
		return $this->connection->setex( $key, $seconds, $value );
	}

	/**
	 *
	 * @param string $key
	 * @return String|NULL
	 */
	public function getKeyValue( string $key ): ?string {
		return $this->connection->get( $key ) ?? null;
	}
}
