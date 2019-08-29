<?php

namespace rikmeijer\Teach\GUI;

use Aura\Router\Map;
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

    public function mapRoutes(Map $map): void
    {
        $map->get(
            'sso.login',
            '/sso/login',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                $this->user->login();
            }
        );
        $map->get(
            'sso.callback',
            '/sso/callback',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                $this->profile();
                return $this->seeOther($response, '/');
            }
        );
        $map->get(
            'sso.profile',
            '/sso/profile',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                $view = new SSO\Profile($this->phpviewDirectory, $this);
                return $view->handleRequest($request)->respond($response);
            }
        );

        $map->get(
            'sso.logout',
            '/logout',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                return $this->seeOther($response, $this->user->logout());
            }
        );
    }

    public function profile()
    {
        return $this->user->profile();
    }

    private function seeOther(ResponseInterface $psrResponse, string $location): ResponseInterface
    {
        return $psrResponse->withStatus('303')->withHeader('Location', $location);
    }
}
