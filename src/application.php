<?php

namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Bootstrap\Bootstrap;

return new class
{

    /**
     * @var Bootstrap
     */
    private $router;

    public function __construct()
    {
        require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        $bootstrap = new Bootstrap(dirname(__DIR__));
        $this->router = $bootstrap->resource('router');
    }

    public function handle(\Psr\Http\Message\ServerRequestInterface $serverRequest): ResponseInterface
    {
        $routeEndPoint = $this->router->route($serverRequest);

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
