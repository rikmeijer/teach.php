<?php

/* 
 * application specific bootstrapper
 */
return function() {
	require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
	
	$resources = require __DIR__ . DIRECTORY_SEPARATOR . 'resources.php';
	if (array_key_exists('database', $resources) === false) {
	    trigger_error('Resource `database` missing.', E_USER_ERROR);
	}
	
	return [
	    'database' => function() use ($resources) {
	        if (class_exists('mysqli') === false) {
	           trigger_error('PHP mysqli extension has not been loaded', E_USER_ERROR);
	        }
	        
	        $databaseResource = $resources['database'];
	        $host = array_key_exists('host', $databaseResource) ? $databaseResource['host'] : 'localhost';
	        $user = array_key_exists('user', $databaseResource) ? $databaseResource['user'] : get_current_user();
	        $password = array_key_exists('password', $databaseResource) ? $databaseResource['password'] : null;
	        $database = array_key_exists('database', $databaseResource) ? $databaseResource['database'] : null;
	        $port = array_key_exists('port', $databaseResource) ? $databaseResource['port'] : null;
	        $socket = array_key_exists('socket', $databaseResource) ? $databaseResource['socket'] : null;
	        
	        return new mysqli($host, $user, $password, $database, $port, $socket);
	    }
	];
};