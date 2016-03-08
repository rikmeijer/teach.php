<?php

interface EnvironmentBootstrap {

    /**
     *
     * @return PDO
     */
    public function getDatabase(): \PDO;
    
    public function getAdapterFactory(): \Teach\Adapters\Factory;
}


return new class() implements EnvironmentBootstrap {

    private $resources;
    
    public function __construct()
    {
        require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        
        $this->resources = require __DIR__ . DIRECTORY_SEPARATOR . 'resources.php';
        if (array_key_exists('database', $this->resources) === false) {
            trigger_error('Resource `database` missing.', E_USER_ERROR);
        }
    }

    /**
     *
     * @return PDO
     */
    public function getDatabase(): \PDO
    {
        if (class_exists('PDO') === false) {
            trigger_error('PHP PDO extension has not been loaded', E_USER_ERROR);
        }
        
        $databaseResource = $this->resources['database'];
        $dsn = [];
        if (array_key_exists('socket', $databaseResource)) {
            $dsn[] = 'unix_socket=' . $databaseResource['socket'];
        } else {
            $dsn[] = 'host=' . (array_key_exists('host', $databaseResource) ? $databaseResource['host'] : 'localhost');
            
            if (array_key_exists('port', $databaseResource)) {
                $dsn[] = 'port=' . $databaseResource['port'];
            }
        }
        if (array_key_exists('database', $databaseResource)) {
            $dsn[] = 'dbname=' . $databaseResource['database'];
        }
        $dsn[] = 'charset=utf8';
        
        $user = array_key_exists('user', $databaseResource) ? $databaseResource['user'] : get_current_user();
        $password = array_key_exists('password', $databaseResource) ? $databaseResource['password'] : null;
        
        return new PDO('mysql:' . join(';', $dsn), $user, $password);
    }
    
    public function getAdapterFactory(): \Teach\Adapters\Factory
    {
        return new \Teach\Adapters\Factory();
    }
};