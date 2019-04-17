<?php
$bootstrap = require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
$config = $bootstrap->config('DB');

return [
    'driver' => 'pdo_' . $config['CONNECTION'],
    'host' => $config['HOST'],
    'dbname' => $config['DATABASE'],
    'user' => $config['USERNAME'],
    'password' => $config['PASSWORD']
];
