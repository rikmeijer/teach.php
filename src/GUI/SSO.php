<?php

namespace rikmeijer\Teach\GUI;

use Aura\Router\Map;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Bootstrap\Bootstrap;
use pulledbits\View\Directory;
use rikmeijer\Teach\ClosureEndPoint;
use rikmeijer\Teach\GUI;

class SSO implements GUI
{
    /**
     * @var \Auth0\SDK\Auth0
     */
    private $auth0;

    /**
     * @var Directory
     */
    private $phpviewDirectory;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->auth0 = $bootstrap->resource('auth0');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function mapRoutes(Map $map): void
    {
        $map->get(
            'sso.login',
            '/sso/login',
            function (ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
                $this->auth0->login();
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
                $this->auth0->logout();
                $return_to = 'https://' . $_SERVER['HTTP_HOST'];
                $logout_url = sprintf(
                    'https://%s/v2/logout?client_id=%s&returnTo=%s',
                    'pulledbits.eu.auth0.com',
                    '2ohAli435Sq92PV14zh9vsXkFqofZrbh',
                    $return_to
                );
                return $this->seeOther($response, $logout_url);
            }
        );
    }

    public function profile()
    {
        return $this->auth0->getUser();
    }

    private function seeOther(ResponseInterface $psrResponse, string $location): ResponseInterface
    {
        return $psrResponse->withStatus('303')->withHeader('Location', $location);
    }
}
