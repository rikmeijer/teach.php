<?php
// ID: 299
$config = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config.php';
return new  Avans\OAuth\Web($config['SSO']);