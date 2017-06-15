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
            '/feedback/(?<contactmomentIdentifier>\d+)/supply' => 'Feedback' . NAMESPACE_SEPARATOR . 'Supply',
            '/feedback/(?<contactmomentIdentifier>\d+)/supply' => 'Feedback' . NAMESPACE_SEPARATOR . 'Supply',
            '/feedback/(?<contactmomentIdentifier>\d+)' => 'Feedback',
            '/rating/(?<contactmomentIdentifier>\d+)' => 'Rating',
            '/contactmoment/import' => 'Contactmoment' . NAMESPACE_SEPARATOR . 'Import',
            '/contactmoment/import' => 'Contactmoment' . NAMESPACE_SEPARATOR . 'Import',
            '/qr' => 'Qr',
            '/' => 'Index'
        ]);
    }

    public function handle() : \Psr\Http\Message\ResponseInterface
    {
        $router = $this->initializeRouterWithRoutes();
        return $router->route($this->bootstrap->request());
    }
};