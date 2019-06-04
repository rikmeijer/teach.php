<?php

use Doctrine\Common\Cache\MemcachedCache;

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : \Doctrine\Common\Cache\Cache {
    $cache = new Doctrine\Common\Cache\MemcachedCache();
    $config = $bootstrap->config('MEMCACHED');
    $memcached = new \Memcached();
    $memcached->addServer($config['host'], $config['port']);
    $cache->setMemcached($memcached);
    return $cache;
};
