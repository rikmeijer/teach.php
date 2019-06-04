<?php

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : \Memcached {
    $config = $bootstrap->config('MEMCACHED');
    $memcached = new \Memcached();
    $memcached->addServer($config['host'], $config['port']);
    return $memcached;
};
