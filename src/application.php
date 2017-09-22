<?php
namespace rikmeijer\Teach;

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
            new Routes\IndexFactoryFactory($this->resources)
        ]);
    }

    public function handle() : \Psr\Http\Message\ResponseInterface
    {
        $server = $this->resources->sso();
        $session = $this->resources->session();

        $sessionToken = $session->getSegment('token');
        $tokenCredentialsSerialized = $sessionToken->get('credentials');
        if ($tokenCredentialsSerialized !== null) {
            $tokenCredentials = unserialize($tokenCredentialsSerialized);
            $user = $sessionToken->get('user');
            if ($user === null) {
                $sessionToken->get('user', serialize($server->getUserDetails($tokenCredentials)));
            }
        }

        $router = $this->initializeRouterWithRoutes();
        return $router->route($this->bootstrap->request());
    }
};