<?php use Doctrine\DBAL\DriverManager;

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : \Doctrine\DBAL\Connection {
    $config = $bootstrap->config('DB');
    return Doctrine\DBAL\DriverManager::getConnection(
        [
            'user' => $config['USERNAME'],
            'password' => $config['PASSWORD'],
            'host' => $config['HOST'],
            'port' => $config['PORT'],
            'driver' => 'pdo_' . $config['CONNECTION'],
            'dbname' => $config['DATABASE'],
        ],
        new \Doctrine\DBAL\Configuration()
    );
};
