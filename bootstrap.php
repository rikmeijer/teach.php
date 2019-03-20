<?php

namespace rikmeijer\Teach;

final class Bootstrap
{
    private $autoloader;
    private $resourcesPath;

    public function __construct()
    {
        $this->autoloader = require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        $this->resourcesPath = __DIR__ . DIRECTORY_SEPARATOR . 'resources';
    }

    public function resource(string $resource)
    {
        static $resources = [];
        if (array_key_exists($resource, $resources)) {
            return $resources[$resource];
        }
        return $resources[$resource] = $this->bootstrap(
            $this->resourcesPath . DIRECTORY_SEPARATOR . $resource . '.php'
        );
    }

    public function bootstrap(string $file, array $args = [])
    {
        return (require $file)($this, ...$args);
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

