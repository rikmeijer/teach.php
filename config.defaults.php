<?php return [
    'DB' => [ // used for Travis-CI
        'CONNECTION' => 'mysql',
        'HOST' => '127.0.0.1',
        'PORT' => '3306',
        'DATABASE' => 'teach',
        'USERNAME' => 'travis',
        'PASSWORD' => '',
        'PREFIX' => '',
    ],
    'BOOTSTRAP' => [
        'path' => __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap',
        'preload' => []
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
