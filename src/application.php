<?php
return new class {

    /**
     * @var \rikmeijer\Teach\Bootstrap
     */
    private $bootstrap;


    public function __construct()
    {
        $this->bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    }

    private function initializeRouterWithRoutes() : \pulledbits\Router\Router {
        return $this->bootstrap->router([
            'GET:/feedback/(?<contactmomentIdentifier>\d+)/supply' => 'GET' . DIRECTORY_SEPARATOR . 'feedback.supply.php',
            'POST:/feedback/(?<contactmomentIdentifier>\d+)/supply' => 'POST' . DIRECTORY_SEPARATOR . 'feedback.supply.php',
            'GET:/feedback/(?<contactmomentIdentifier>\d+)' => 'GET' . DIRECTORY_SEPARATOR . 'feedback.php',
            'GET:/rating/(?<contactmomentIdentifier>\d+)' => 'GET' . DIRECTORY_SEPARATOR . 'rating.php',
            'GET:/contactmoment/import' => 'GET' . DIRECTORY_SEPARATOR . 'contactmoment.import.php',
            'POST:/contactmoment/import' => 'POST' . DIRECTORY_SEPARATOR . 'contactmoment.import.php',
            'GET:/qr' => 'GET' . DIRECTORY_SEPARATOR . 'qr.php',
            'GET:/' => 'GET' . DIRECTORY_SEPARATOR . 'index.php'
        ]);
    }

    public function handle() : \Psr\Http\Message\ResponseInterface
    {
        $router = $this->initializeRouterWithRoutes();

        $route = $router->route($this->bootstrap->request());

        if ($route === false) {
            return $this->bootstrap->response(404, 'Failure');
        }

        return $route->execute([$this->bootstrap->resources()]);
    }
};