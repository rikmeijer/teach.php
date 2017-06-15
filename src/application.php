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
            'GET:/feedback/(?<contactmomentIdentifier>\d+)/supply' => 'Feedback' . NAMESPACE_SEPARATOR . 'Supply',
            'POST:/feedback/(?<contactmomentIdentifier>\d+)/supply' => 'Feedback' . NAMESPACE_SEPARATOR . 'Supply',
            'GET:/feedback/(?<contactmomentIdentifier>\d+)' => 'Feedback',
            'GET:/rating/(?<contactmomentIdentifier>\d+)' => 'Rating',
            'GET:/contactmoment/import' => 'Contactmoment' . NAMESPACE_SEPARATOR . 'Import',
            'POST:/contactmoment/import' => 'Contactmoment' . NAMESPACE_SEPARATOR . 'Import',
            'GET:/qr' => 'Qr',
            'GET:/' => 'Index'
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