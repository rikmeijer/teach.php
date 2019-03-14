<?php return function(\rikmeijer\Teach\Bootstrap $bootstrap) {
    $router = new \pulledbits\Router\Router([]);

    foreach (glob($bootstrap->config('ROUTER')['path'] . DIRECTORY_SEPARATOR . '*.php') as $file) {
        (require $file)($bootstrap, $router);
    }
    return $router;
};