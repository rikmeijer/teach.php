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
            '/feedback/(?<contactmomentIdentifier>\d+)/supply' => 'feedback.supply',
            '/feedback/(?<contactmomentIdentifier>\d+)' => 'feedback',
            '/rating/(?<contactmomentIdentifier>\d+)' => 'rating',
            '/contactmoment/import' => 'contactmoment.import',
            '/qr' => 'qr',
            '/' => 'index'
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