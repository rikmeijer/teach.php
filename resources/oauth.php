<?php return function(\rikmeijer\Teach\Bootstrap $bootstrap) {
    $config = require __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
    return new \Avans\OAuth\Web($config['SSO']);
};