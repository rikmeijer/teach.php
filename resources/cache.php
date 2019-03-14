<?php return function(\rikmeijer\Teach\Bootstrap $bootstrap) {
    $resources = require __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

    $client = new \Memcached();
    $client->addServer($resources['MEMCACHED']['host'], $resources['MEMCACHED']['port']);
    return new \Cache\Adapter\Memcached\MemcachedCachePool($client);
};