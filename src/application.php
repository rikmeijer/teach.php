<?php
namespace rikmeijer\Teach;

return new class {

    /**
     * @var Bootstrap
     */
    private $bootstrap;

    public function __construct()
    {
        $this->bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    }

    public function handle(\Psr\Http\Message\ServerRequestInterface $serverRequest) : array
    {
        $cache = $this->bootstrap->cache();
        $cacheId = sha1(serialize(array_merge([$serverRequest->getUri()->__toString()], $serverRequest->getAttributes(), $serverRequest->getCookieParams(), $serverRequest->getQueryParams())));
        if ($serverRequest->getMethod() !== 'GET' || $cache->has($cacheId) === false) {

            switch ($serverRequest->getMethod()) {
                case 'POST':
                    $responseCode = '201';
                    break;
                default:
                    $responseCode = '200';
                    break;
            }

            $router = $this->bootstrap->router();
            $routeEndPoint = $router->route($serverRequest);

            $handledRequest = $routeEndPoint->respond(new \GuzzleHttp\Psr7\Response($responseCode));

            $cache->set($cacheId, [
                'status' => $handledRequest->getStatusCode(),
                'headers' => $handledRequest->getHeaders(),
                'body' => $handledRequest->getBody()->getContents()
            ]);
        }
        return $cache->get($cacheId);
    }
};