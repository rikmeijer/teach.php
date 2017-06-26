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
            $resources = new Resources(__DIR__ . DIRECTORY_SEPARATOR . 'resources', new Response(function (int $status, string $body): \Psr\Http\Message\ResponseInterface {
                return $this->response($status, $body);
            }));

            return new \pulledbits\Router\Router(array_map(function ($v) use ($resources) {
                $class = __NAMESPACE__ . NAMESPACE_SEPARATOR . 'Routes' . NAMESPACE_SEPARATOR . $v;
                return new $class($resources, $resources->phpview(DIRECTORY_SEPARATOR . str_replace(NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $v)));
            }, $routes));
        }

        public function request(): \Psr\Http\Message\ServerRequestInterface
        {
            return \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
        }

        public function response(int $status, string $body): \Psr\Http\Message\ResponseInterface
        {
            return (new \GuzzleHttp\Psr7\Response($status))->withBody(\GuzzleHttp\Psr7\stream_for($body));
        }

    };
}