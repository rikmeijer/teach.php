<?php

/* 
 * public specific bootstrapper
 */
return function() {
    $applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    $applicationBootstrap();
};
