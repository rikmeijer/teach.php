<?php
$pdo = require __DIR__ . DIRECTORY_SEPARATOR . 'pdo.php';
$connection = new pulledbits\ActiveRecord\SQL\Connection($pdo);
return $connection->schema($config['DB_DATABASE']);
