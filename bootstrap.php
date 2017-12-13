<?php

namespace {

    define('NAMESPACE_SEPARATOR', '\\');

    function get_class_shortname($object) {
        $classname = get_class($object);
        return (substr($classname, strrpos($classname, '\\') + 1));
    }

    function get_absolute_path($path) {
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }
}

namespace rikmeijer\Teach {

    require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

    return new class implements Bootstrap
    {
        static $resources;

        public function router(array $routes): \pulledbits\Router\Router
        {
            return new \pulledbits\Router\Router($routes);
        }

        public function resources() : Resources {
            return new Resources(__DIR__ . DIRECTORY_SEPARATOR . 'resources');
        }

        public function request(): \Psr\Http\Message\ServerRequestInterface
        {
            return \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
        }
    };
}