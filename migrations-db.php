<?php
$config = (require __DIR__ . DIRECTORY_SEPARATOR . 'config.php')['DB'];

return [
    'driver' => 'pdo_mysql',
    'host' => $config['HOST'],
    'dbname' => $config['DATABASE'],
    'user' => $config['USERNAME'],
    'password' => $config['PASSWORD']
];
