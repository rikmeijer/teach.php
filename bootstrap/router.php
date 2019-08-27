<?php

namespace rikmeijer\Teach;

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {
    $routesPath = $bootstrap->config('ROUTER')['path'] . DIRECTORY_SEPARATOR;
    $routes = [];
    foreach (glob($routesPath . '*.php') as $file) {
        $guiClassName = GUI::class . '\\' . str_replace([$routesPath, '.php'], '', $file);
        $gui = new $guiClassName($bootstrap);
        if ($gui instanceof GUI) {
            $routes += $gui->createRoutes();
        }
    }
    return new \pulledbits\Router\Router($routes);
};
