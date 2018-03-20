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

    public function handle() : RouteEndPoint
    {
        $session = $this->resources->session();
        $user = $this->resources->userForToken();
        $schema = $this->resources->schema();
        $phpviewDirectory = $this->resources->phpviewDirectory('');

        $router = $this->bootstrap->router([
            new Routes\Feedback\SupplyFactoryFactory($schema, $this->resources->assets(), $this->resources->phpviewDirectory('feedback'), $session),
            new Routes\FeedbackFactoryFactory($schema, $phpviewDirectory),
            new Routes\RatingFactoryFactory($this->resources),
            new Routes\Contactmoment\ImportFactoryFactory($user, $this->resources),
            new Routes\QrFactoryFactory($this->resources),
            new Routes\SSO\CallbackFactoryFactory($this->resources),
            new Routes\LogoutFactoryFactory($session),
            new Routes\IndexFactoryFactory($user, $schema, $phpviewDirectory)
        ]);
        return $router->route($this->bootstrap->request());
    }
};