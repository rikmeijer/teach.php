<?php
namespace rikmeijer\Teach;

return new class {

    /**
     * @var Bootstrap
     */
    private $bootstrap;


    public function __construct()
    {
        $this->bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    }

    private function initializeRouterWithRoutes() : \pulledbits\Router\Router {
        $resources = $this->bootstrap->resources();

        return $this->bootstrap->router([
            new Routes\Feedback\Supply($resources),
            new Routes\Feedback($resources),
            new Routes\Rating($resources),
            new Routes\Contactmoment\Import($resources),
            new Routes\Qr($resources),
            new Routes\Index($resources)
        ]);
    }

    public function handle() : \Psr\Http\Message\ResponseInterface
    {
        $router = $this->initializeRouterWithRoutes();
        return $router->route($this->bootstrap->request());
    }
};