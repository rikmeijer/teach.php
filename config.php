<?php

return [
    'DB' => [
        'CONNECTION' => 'mysql',
        'HOST' => 'localhost',
        'DATABASE' => 'teach',
        'USERNAME' => 'teach',
        'PASSWORD' => 'teach',
        'PREFIX' => '',
    ],

    'OAUTH' => [
        'identifier' => "6efc1dcdfb0aba7ce803e583c083f4d3ce3e04cd",
        "secret" => "bf9129cf953e0d92d8b008364a06ebe4765e0bc6",
        'callback_uri' => 'https://teach.local.rikmeijer.nl/sso/callback'
    ],

    'AUTH0' => [
        'domain' => 'pulledbits.eu.auth0.com',
        'redirect_uri' => 'http://teach.local.rikmeijer.nl/sso/callback',
        'client_id' => '2ohAli435Sq92PV14zh9vsXkFqofZrbh',
        'client_secret' => 'tUaX3SyO2niLW8X4O-2HnLutDCKvhHEGKJZOMIucfU3gqxfwGpWo-QeusMqpFlh3'
    ],

    'MEMCACHED' => [
        'host' => 'localhost',
        'port' => 11211
    ],
];
