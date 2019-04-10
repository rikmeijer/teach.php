<?php

namespace rikmeijer\Teach;

use Micheh\Cache\CacheUtil;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;
use pulledbits\Bootstrap\Bootstrap;

return new class
{

    /**
     * @var Bootstrap
     */
    private $bootstrap;

    public function __construct()
    {
        require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        $this->bootstrap = new Bootstrap(dirname(__DIR__));
    }

    public function handle(\Psr\Http\Message\ServerRequestInterface $serverRequest): ResponseInterface
    {
        $routeEndPoint = $this->bootstrap->resource('router')->route($serverRequest);

        switch ($serverRequest->getMethod()) {
            case 'POST':
                $responseCode = '201';
                break;
            default:
                $responseCode = '200';
                break;
        }
        return $routeEndPoint->respond(new \GuzzleHttp\Psr7\Response($responseCode));
    }
};
