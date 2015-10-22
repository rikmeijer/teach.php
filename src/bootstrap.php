<?php

/* 
 * public specific bootstrapper
 */
return function() {
    $applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    $applicationBootstrap();
    
    return function($lesplanIdentifier) {
        return include __DIR__ . DIRECTORY_SEPARATOR . 'lesplannen' . DIRECTORY_SEPARATOR . $lesplanIdentifier . '.php';
    };
};
