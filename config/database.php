<?php

return [
	/*
	|	----------------------------------------------------------------------	----
	| Database Connection Driver
	|	----------------------------------------------------------------------	----
	|
	| This value specifies which database connection driver the 	application should use.
	| It allows the application to easily switch between different  database systems
	| such as MySQL, SQLite, etc. By default, it uses 'mysql'.
	|
	*/
	'db_connection' => getenv( 'DB_CONNECTION' ) ?: 'mysql',


	/*
	|--------------------------------------------------------------------------
	| Database Host
	|--------------------------------------------------------------------------
	|
	| This value is the host of the database. This value is used when the
	| app needs to connect to the database
	|
	*/

	'db_host'       => getenv( 'DB_HOST' ) ?: 'db',

	/*
	|--------------------------------------------------------------------------
	| Database Port
	|--------------------------------------------------------------------------
	|
	| This value determines the port the database is currently running on
	|
	*/

	'db_port'       => getenv( 'DB_PORT' ) ?: '3306',

	/*
	|--------------------------------------------------------------------------
	| Database Name
	|--------------------------------------------------------------------------
	|
	| This value defines the name of the database the application should connect to
	|
	*/

	'db_name'       => getenv( 'DB_DATABASE' ) ?: '',

	/*
	|--------------------------------------------------------------------------
	| Database User
	|--------------------------------------------------------------------------
	|
	| This defines the username that gives the application access to the database
	|
	*/

	'db_user'       => getenv( 'DB_USER' ) ?: '',

	/*
	|--------------------------------------------------------------------------
	| Database Password
	|--------------------------------------------------------------------------
	|
	| This defines the password credential of that gives the application access to the databse
	|
	*/

	'db_password'   => getenv( 'DB_PASSWORD' ) ?: '',

];
