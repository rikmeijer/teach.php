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
            new Routes\Feedback\SupplyFactoryFactory($resources),
            new Routes\FeedbackFactoryFactory($resources),
            new Routes\RatingFactoryFactory($resources),
            new Routes\Contactmoment\ImportFactoryFactory($resources),
            new Routes\QrFactoryFactory($resources),
            new Routes\IndexFactoryFactory($resources)
        ]);
    }

    public function handle() : \Psr\Http\Message\ResponseInterface
    {
        $router = $this->initializeRouterWithRoutes();
        return $router->route($this->bootstrap->request());
    }
};