<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {
    $pdo = $bootstrap->resource('pdo');

    $config = $bootstrap->config('DB');
    $connection = new pulledbits\ActiveRecord\SQL\Connection($pdo);
    return $connection->schema($config['DATABASE']);
};
