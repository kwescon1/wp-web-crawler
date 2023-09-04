<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Redis Scheme
	|--------------------------------------------------------------------------
	|
	| This value is the scheme used to connect to the Redis database. Common
	| schemes include 'tcp' (default) and 'unix' for Unix domain sockets.
	|
	*/

	'redis_scheme'   => getenv( 'REDIS_SCHEME' ) ?: 'tcp',

	/*
	|--------------------------------------------------------------------------
	| Redis Host
	|--------------------------------------------------------------------------
	|
	| This value is the host of the redis database. This value is used when the app needs to connect to redis
	|
	*/

	'redis_host'     => getenv( 'REDIS_HOST' ) ?: 'redis',

	/*
	|--------------------------------------------------------------------------
	| Redis Port
	|--------------------------------------------------------------------------
	|
	| This value determines the port the redis database is currently running on
	|
	*/

	'redis_port'     => getenv( 'REDIS_PORT' ) ?: '6379',

	/*
	|--------------------------------------------------------------------------
	| Redis Password
	|--------------------------------------------------------------------------
	|
	| This defines the password credential of that gives the application access to the databse
	|
	*/

	'redis_password' => getenv( 'REDIS_PASSWORD' ) ?: '',

];
