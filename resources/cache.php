<?php return function(\rikmeijer\Teach\Bootstrap $bootstrap) {
    $config = $bootstrap->config('MEMCACHED');
    $client = new \Memcached();
    $client->addServer($config['host'], $config['port']);
    return new \Cache\Adapter\Memcached\MemcachedCachePool($client);
};