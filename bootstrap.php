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
	        $database = $resources['database'];
	        $host = array_key_exists('host', $database) ? $database['host'] : 'localhost';
	        $user = array_key_exists('user', $database) ? $database['user'] : get_current_user();
	        $password = array_key_exists('password', $database) ? $database['password'] : null;
	        $database = array_key_exists('database', $database) ? $database['database'] : null;
	        $port = array_key_exists('port', $database) ? $database['port'] : null;
	        $socket = array_key_exists('socket', $database) ? $database['socket'] : null;
	        
	        return new mysqli($host, $user, $password, $database, $port, $socket);
	    }
	];
};