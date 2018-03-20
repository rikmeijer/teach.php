<?php
namespace rikmeijer\Teach;

use League\OAuth1\Client\Server\User;
use pulledbits\Router\RouteEndPoint;

return new class {

    /**
     * @var Bootstrap
     */
    private $bootstrap;

    public function __construct()
    {
        $this->bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
    }

    public function handle() : RouteEndPoint
    {
        $resources = $this->bootstrap->resources();
        $router = $this->bootstrap->router($resources->routes());
        return $router->route($this->bootstrap->request());
    }
};