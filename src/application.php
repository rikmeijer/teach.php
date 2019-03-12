<?php
namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;

return new class {

    /**
     * @var Bootstrap
     */
    private $bootstrap;

    public function __construct()
    {
        $this->bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    }

    public function handle(\Psr\Http\Message\ServerRequestInterface $serverRequest) : ResponseInterface
    {
        $router = $this->bootstrap->router();
        $routeEndPoint = $router->route($serverRequest);

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