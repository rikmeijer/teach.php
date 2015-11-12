<?php

/*
 * public specific bootstrapper
 */
return function () {
    $applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    $resourceFactory = $applicationBootstrap();
    
    $databaseFactory = $resourceFactory['database'];
    
    return function ($lesplanIdentifier) use ($databaseFactory) {
        $filename = __DIR__ . DIRECTORY_SEPARATOR . 'lesplannen' . DIRECTORY_SEPARATOR . $lesplanIdentifier . '.php';
        if (file_exists($filename) === false) {
            return null;
        }
        $lesplanFactory = include $filename;
        return $lesplanFactory($databaseFactory());
    };
};
