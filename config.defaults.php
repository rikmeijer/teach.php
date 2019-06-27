<?php

$config = [];
if (in_array('gs', stream_get_wrappers())) {
    $config = include 'gs://teach-242612.appspot.com/config/config.php';
}

return array_merge_recursive([
    'DB' => [
        'CONNECTION' => getenv('DB_CONNECTION'),
        'HOST' => getenv('DB_HOST'),
        'PORT' => getenv('DB_PORT'),
        'DATABASE' => getenv('DB_DATABASE'),
        'USERNAME' => getenv('DB_USERNAME'),
        'PASSWORD' => getenv('DB_PASSWORD'),
        'PREFIX' => getenv('DB_PREFIX')
    ],

    'OAUTH' => [
        'identifier' => getenv('OAUTH_CLIENT_ID'),
        "secret" => getenv('OAUTH_CLIENT_SECRET'),
        'callback_uri' => getenv('OAUTH_CALLBACK_URI')
    ],

    'MEMCACHED' => [
        'host' => getenv('MEMCACHED_HOST'),
        'port' => getenv('MEMCACHED_PORT')
    ],

    'BOOTSTRAP' => [
        'path' => __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap'
    ],
    'ROUTER' => [
        'path' => __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'GUI'
    ],
    'PHPVIEW' => [
        'path' => __DIR__ . DIRECTORY_SEPARATOR . 'phpview'
    ],
    'ASSETS' => [
        'path' => __DIR__ . DIRECTORY_SEPARATOR . 'assets'
    ]
], $config);
