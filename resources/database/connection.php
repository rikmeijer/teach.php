<?php
$config = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config.php';
$pdo = new \PDO($config['DB_CONNECTION'] . ':', $config['DB_USERNAME'], $config['DB_PASSWORD'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
$connection = new pulledbits\ActiveRecord\SQL\Connection($pdo);
return $connection->schema($config['DB_DATABASE']);
