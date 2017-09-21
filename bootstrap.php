<?php

namespace {

    define('NAMESPACE_SEPARATOR', '\\');

    function get_class_shortname($object) {
        $classname = get_class($object);
        return (substr($classname, strrpos($classname, '\\') + 1));
    }
}

namespace rikmeijer\Teach {

    require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

    return new class implements Bootstrap
    {
        public function router(array $routes): \pulledbits\Router\Router
        {
            $resources = new Resources(__DIR__ . DIRECTORY_SEPARATOR . 'resources');

            return new \pulledbits\Router\Router(array_map(function ($v) use ($resources) {
                $class = __NAMESPACE__ . NAMESPACE_SEPARATOR . 'Routes' . NAMESPACE_SEPARATOR . $v;
                return new $class($resources);
            }, $routes));
        }

        public function request(): \Psr\Http\Message\ServerRequestInterface
        {
            return \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
        }
    };
}