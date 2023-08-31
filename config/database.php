<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Database Host
	|--------------------------------------------------------------------------
	|
	| This value is the host of the database. This value is used when the
	| app needs to connect to the database
	|
	*/

	'db_host'     => getenv( 'MYSQL_HOST' ) ?: 'db',

	/*
	|--------------------------------------------------------------------------
	| Database Port
	|--------------------------------------------------------------------------
	|
	| This value determines the port the database is currently running on
	|
	*/

	'db_port'     => getenv( 'MYSQL_PORT' ) ?: '3306',

	/*
	|--------------------------------------------------------------------------
	| Database Name
	|--------------------------------------------------------------------------
	|
	| This value defines the name of the database the application should connect to
	|
	*/

	'db_name'     => getenv( 'MYSQL_DATABASE' ) ?: '',

	/*
	|--------------------------------------------------------------------------
	| Database User
	|--------------------------------------------------------------------------
	|
	| This defines the username that gives the application access to the database
	|
	*/

	'db_user'     => getenv( 'MYSQL_USER' ) ?: '',

	/*
	|--------------------------------------------------------------------------
	| Database Password
	|--------------------------------------------------------------------------
	|
	| This defines the password credential of that gives the application access to the databse
	|
	*/

	'db_password' => getenv( 'MYSQL_PASSWORD' ) ?: '',

];
