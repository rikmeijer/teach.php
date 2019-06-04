<?php

use Doctrine\Common\Cache\MemcachedCache;

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : \Doctrine\Common\Cache\Cache {
    $cache = new Doctrine\Common\Cache\MemcachedCache();
    $cache->setMemcached($bootstrap->resource('memcached'));
    return $cache;
};
