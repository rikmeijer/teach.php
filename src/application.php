<?php
namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;

return new class {

    /**
     * @var Bootstrap
     */
    private $router;

    public function __construct()
    {
        $bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
        $this->router = $bootstrap->resource('router');
    }

    public function handle(\Psr\Http\Message\ServerRequestInterface $serverRequest) : ResponseInterface
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