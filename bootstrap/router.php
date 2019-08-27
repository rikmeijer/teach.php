<?php

namespace rikmeijer\Teach;

use Aura\Router\Matcher;
use Aura\Router\RouterContainer;

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : Matcher {
    $routesPath = $bootstrap->config('ROUTER')['path'] . DIRECTORY_SEPARATOR;

    $routerContainer = new RouterContainer();
    $map = $routerContainer->getMap();
    foreach (glob($routesPath . '*.php') as $file) {
        $guiClassName = GUI::class . '\\' . str_replace([$routesPath, '.php'], '', $file);
        $gui = new $guiClassName($bootstrap);
        if ($gui instanceof GUI) {
            $gui->mapRoutes($map);
        }
    }
    return $routerContainer->getMatcher();
};
