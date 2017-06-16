<?php

namespace {

    define('NAMESPACE_SEPARATOR', '\\');
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
                return new class(__NAMESPACE__ . NAMESPACE_SEPARATOR . 'Routes' . NAMESPACE_SEPARATOR . $v, $resources) implements \pulledbits\Router\Handler
                {
                    private $baseRoute;
                    private $resources;

                    public function __construct(string $baseRoute, Resources $resources)
                    {
                        $this->baseRoute = $baseRoute;
                        $this->resources = $resources;
                    }

                    function handleRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
                    {
                        $class = $this->baseRoute . NAMESPACE_SEPARATOR . ucfirst(strtolower($request->getMethod()));
                        if (class_exists($class)) {
                            $route = new $class();
                            return $route($request, $this->resources);
                        }
                        return $this->resources->respond(405, 'Method not allowed');
                    }
                };
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