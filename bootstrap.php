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
            return new \pulledbits\Router\Router(array_map(function ($v) {
                return function (\Psr\Http\Message\RequestInterface $request, Resources $resources) use ($v) : \Psr\Http\Message\ResponseInterface {
                    $class = __NAMESPACE__ . NAMESPACE_SEPARATOR .  'Routes' . NAMESPACE_SEPARATOR . $v . NAMESPACE_SEPARATOR . ucfirst(strtolower($request->getMethod()));
                    if (class_exists($class)) {
                        $route = new $class();
                        return $route($request, $resources);
                    }
                    return $resources->respond(405, 'Method not allowed');
                };
            },
                $routes));
        }

        public function request(): \Psr\Http\Message\ServerRequestInterface
        {
            return \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
        }

        public function response(int $status, string $body): \Psr\Http\Message\ResponseInterface
        {
            return (new \GuzzleHttp\Psr7\Response($status))->withBody(\GuzzleHttp\Psr7\stream_for($body));
        }

        public function resources(): Resources
        {
            return new Resources(__DIR__ . DIRECTORY_SEPARATOR . 'resources',
                new Response(function (
                    int $status,
                    string $body
                ): \Psr\Http\Message\ResponseInterface {
                    return $this->response($status, $body);
                }));
        }
    };
}