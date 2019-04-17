<?php

namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Bootstrap\Bootstrap;

return new class
{

    /**
     * @var Bootstrap
     */
    private $bootstrap;

    public function __construct()
    {
        $this->bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
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
