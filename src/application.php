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
        $resources = $this->bootstrap->resources();

        return $this->bootstrap->router([
            new \rikmeijer\Teach\Routes\Feedback\Supply($resources),
            new \rikmeijer\Teach\Routes\Feedback($resources),
            new \rikmeijer\Teach\Routes\Rating($resources),
            new \rikmeijer\Teach\Routes\Contactmoment\Import($resources),
            new \rikmeijer\Teach\Routes\Qr($resources),
            new \rikmeijer\Teach\Routes\Index($resources)
        ]);
    }

    public function handle() : \Psr\Http\Message\ResponseInterface
    {
        $router = $this->initializeRouterWithRoutes();
        return $router->route($this->bootstrap->request());
    }
};