<?php

namespace App\Database;

use Predis\Client;

class Redis {


	// Hold the single instance of the RedisConnection class
	private static $instance = null;

	// Predis client instance for Redis connection
	private Client $client;

	// Redis server host and port and scheme
	private string $host;
	private int $port;
	private string $scheme;

	// Private constructor to prevent direct instantiation
	private function __construct() {
		// Get the configuration values from the included file
		$config = require_once __DIR__ . '/../../config/redis.php';

		// Initialize the Predis client
		$this->host   = $config['redis_host'];
		$this->port   = $config['redis_port'];
		$this->scheme = $config['redis_scheme'];

		try {
			$this->client = new Client(
				[
					'scheme' => $this->scheme,
					'host'   => $this->host,
					'port'   => $this->port,
				]
			);
		} catch ( \Exception $exception ) {
			// Handle connection errors here
			throw new \Exception( $exception->getMessage(), (int) $exception->getCode() );
		}
	}

	// Get a single instance of the RedisConnection class
	public static function getInstance(): self {
		// If no instance exists, create one
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		// Return the instance
		return self::$instance;
	}

	// Get the Predis client instance for Redis operations
	public function getClient(): Client {
		return $this->client;
	}
}
