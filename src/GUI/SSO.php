<?php

namespace rikmeijer\Teach\GUI;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Bootstrap\Bootstrap;
use pulledbits\View\Directory;
use rikmeijer\Teach\ClosureEndPoint;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\User;

class SSO implements GUI
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Directory
     */
    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->user = $bootstrap->resource('user');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute(
            '/sso/login',
            function (ServerRequestInterface $request, callable $next): ResponseInterface {
                $this->user->login();
            }
        );
        $router->addRoute(
            '/sso/callback',
            function (ServerRequestInterface $request, callable $next): ResponseInterface {
                $this->details();
                return $this->seeOther($next($request), '/');
            }
        );
        $router->addRoute('/sso/profile', new SSO\Profile($this->phpviewDirectory, $this));
        $router->addRoute('/logout',
            function (ServerRequestInterface $request, callable $next): ResponseInterface {
                return $this->seeOther($next($request), $this->user->logout());
            });
    }

    private function seeOther(ResponseInterface $psrResponse, string $location): ResponseInterface
    {
        return $psrResponse->withStatus('303')->withHeader('Location', $location);
    }

    public function details()
    {
        return $this->user->details();
    }
}
