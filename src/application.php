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

    public function handle(\Psr\Http\Message\ServerRequestInterface $request) : RouteEndPoint
    {
        $router = $this->bootstrap->router();
        return $router->route($request);
    }
};