<?php
namespace rikmeijer\Teach;

use League\OAuth1\Client\Server\User;
use pulledbits\Router\RouteEndPoint;

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

        $session = $this->resources->session();
        $user = $this->resources->userForToken($this->resources->token());
        $schema = $this->resources->schema();
        $phpviewDirectory = $this->resources->phpviewDirectory('');

        return $this->bootstrap->router([
            new Routes\Feedback\SupplyFactoryFactory($this->resources),
            new Routes\FeedbackFactoryFactory($this->resources),
            new Routes\RatingFactoryFactory($this->resources),
            new Routes\Contactmoment\ImportFactoryFactory($this->resources),
            new Routes\QrFactoryFactory($this->resources),
            new Routes\SSO\CallbackFactoryFactory($this->resources),
            new Routes\LogoutFactoryFactory($session),
            new Routes\IndexFactoryFactory($user, $schema, $phpviewDirectory)
        ]);
    }

    public function handle() : RouteEndPoint
    {
        $router = $this->initializeRouterWithRoutes();
        return $router->route($this->bootstrap->request());
    }
};