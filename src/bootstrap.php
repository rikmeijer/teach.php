<?php

/*
 * public specific bootstrapper
 */
return function () {
    $applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    $applicationBootstrap();
    
    return function ($lesplanIdentifier) {
        $filename = __DIR__ . DIRECTORY_SEPARATOR . 'lesplannen' . DIRECTORY_SEPARATOR . $lesplanIdentifier . '.php';
        if (file_exists($filename) === false) {
            return null;
        }
        return include $filename;
    };
};
