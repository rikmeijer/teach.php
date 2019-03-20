<?php

namespace rikmeijer\Teach;

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

final class Bootstrap
{
    public function resource(string $resource)
    {
        static $resources = [];
        if (array_key_exists($resource, $resources)) {
            return $resources[$resource];
        }
        $path = $this->config('BOOSTRAP')['path'];
        return $resources[$resource] = (require $path . DIRECTORY_SEPARATOR . $resource . '.php')($this);
    }

    public function config(string $section): array
    {
        static $config;
        if (isset($config) === false) {
            $defaults = (require __DIR__ . DIRECTORY_SEPARATOR . 'config.defaults.php');
            $environment = (require __DIR__ . DIRECTORY_SEPARATOR . 'config.php');
            $config = array_merge($defaults, $environment);
        }
        return $config[$section];
    }
}

return new Bootstrap();

