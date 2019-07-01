<?php return [
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

    'AUTH0' => [
        'persist_id_token' => true,
        'persist_access_token' => true,
        'persist_refresh_token' => true,
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
];
