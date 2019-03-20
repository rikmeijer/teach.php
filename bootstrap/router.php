<?php

namespace rikmeijer\Teach;

return function (\rikmeijer\Teach\Bootstrap $bootstrap) {
    $router = new \pulledbits\Router\Router([]);

    $routesPath = $bootstrap->config('ROUTER')['path'] . DIRECTORY_SEPARATOR;
    foreach (glob($routesPath . '*.php') as $file) {
        $guiClassName = GUI::class . '\\' . str_replace([$routesPath, '.php'], '', $file);
        $gui = new $guiClassName($bootstrap);
        if ($gui instanceof GUI) {
            $gui->addRoutesToRouter($router);
        }
    }
    return $router;
};
