<?php

namespace rikmeijer\Teach\GUI\SSO;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;

class Logout implements Route
{
    private $gui;

    public function __construct(\rikmeijer\Teach\GUI\SSO $gui)
    {
        $this->gui = $gui;
    }

    public function handleRequest(ServerRequestInterface $request): RouteEndPoint
    {
        return $this->gui->logout();
    }
}
