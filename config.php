<?php return [
    'DB' => [
        'CONNECTION' => 'mysql',
        'HOST' => '127.0.0.1',
        'PORT' => '3306',
        'DATABASE' => 'teach',
        'USERNAME' => 'teach',
        'PASSWORD' => 'teach',
        'PREFIX' => '',
    ],

    'OAUTH' => [
        'identifier' => "6efc1dcdfb0aba7ce803e583c083f4d3ce3e04cd",
        "secret" => "bf9129cf953e0d92d8b008364a06ebe4765e0bc6",
        'callback_uri' => 'https://teach.local.pulledbits.org/sso/callback'
    ],

    'MEMCACHED' => [
        'host' => 'localhost',
        'port' => 11211
    ],
    'ROUTER' => [
        'path' => __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'GUI'
    ],
    'PHPVIEW' => [
        'path' => __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'phpview'
    ],
    'ASSETS' => [
        'path' => __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'assets'
    ]
];
