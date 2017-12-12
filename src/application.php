<?php
namespace rikmeijer\Teach;

use League\OAuth1\Client\Server\User;
use pulledbits\Router\ResponseFactory;

return new class {

    /**
     * @var Bootstrap
     */
    private $bootstrap;

    /**
     * @var Resources
     */
    private $resources;

    public function __construct()
    {
        $this->bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
        $this->resources = $this->bootstrap->resources();
    }

    private function initializeRouterWithRoutes() : \pulledbits\Router\Router {

        return $this->bootstrap->router([
            new Routes\Feedback\SupplyFactoryFactory($this->resources),
            new Routes\FeedbackFactoryFactory($this->resources),
            new Routes\RatingFactoryFactory($this->resources),
            new Routes\Contactmoment\ImportFactoryFactory($this->resources),
            new Routes\QrFactoryFactory($this->resources),
            new Routes\SSO\CallbackFactoryFactory($this->resources),
            new Routes\LogoutFactoryFactory($this->resources),
            new Routes\IndexFactoryFactory($this->resources)
        ]);
    }

    public function handle() : ResponseFactory
    {
        $router = $this->initializeRouterWithRoutes();
        return $router->route($this->bootstrap->request());
    }
};