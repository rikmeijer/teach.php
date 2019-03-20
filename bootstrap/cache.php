<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap): \Psr\SimpleCache\CacheInterface {
    $config = $bootstrap->config('MEMCACHED');
    $client = new \Memcached();
    $client->addServer($config['host'], $config['port']);
    return new \Cache\Adapter\Memcached\MemcachedCachePool($client);
};
