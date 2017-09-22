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
            'Feedback' . NAMESPACE_SEPARATOR . 'Supply',
            'Feedback',
            'Rating',
            'Contactmoment' . NAMESPACE_SEPARATOR . 'Import',
            'Qr',
            'Index'
        ]);
    }

    public function handle() : \Psr\Http\Message\ResponseInterface
    {
        $router = $this->initializeRouterWithRoutes();
        return $router->route($this->bootstrap->request());
    }
};