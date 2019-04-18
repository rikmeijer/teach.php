<?php
echo "Regenerating Daos and Beans...";
$bootstrap = require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
$bootstrap->resource('tdbm')->generateAllDaosAndBeans();
echo 'OK' . PHP_EOL;