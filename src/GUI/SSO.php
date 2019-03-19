<?php

namespace rikmeijer\Teach\GUI;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Bootstrap;
use rikmeijer\Teach\ClosureEndPoint;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\SeeOtherEndPoint;

class SSO implements GUI
{
    private $session;
    private $server;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->server = $bootstrap->resource('oauth');
        $this->session = $bootstrap->resource('session');
    }

    public function logout(): void
    {
        if ($this->session->isStarted()) {
            $this->session->getSegment('token')->clear();
            $this->session->clear();
            $this->session->destroy();
        }
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('^/sso/authorize', function (): Route {
            return new class($this) implements Route
            {
                private $gui;

                public function __construct(\rikmeijer\Teach\GUI\SSO $gui)
                {
                    $this->gui = $gui;
                }

                public function handleRequest(ServerRequestInterface $request): RouteEndPoint
                {
                    return new SeeOtherEndPoint($this->gui->acquireTemporaryCredentials());
                }
            };
        });
        $router->addRoute('^/sso/callback', function (): Route {
            return new class($this) implements Route
            {
                private $gui;

                public function __construct(\rikmeijer\Teach\GUI\SSO $gui)
                {
                    $this->gui = $gui;
                }

                public function handleRequest(ServerRequestInterface $request): RouteEndPoint
                {
                    $queryParams = $request->getQueryParams();

                    if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
                        $this->gui->authorizeTokenCredentials($queryParams['oauth_token'], $queryParams['oauth_verifier']);
                        return new SeeOtherEndPoint('/');
                    } else {
                        return ErrorFactory::makeInstance(400);
                    }
                }
            };
        });
        $router->addRoute('^/logout', function (): Route {
            return new class($this) implements Route
            {
                private $gui;

                public function __construct(\rikmeijer\Teach\GUI\Index $gui, Directory $phpviewDirectory)
                {
                    $this->gui = $gui;
                }

                public function handleRequest(ServerRequestInterface $request): RouteEndPoint
                {
                    $this->gui->logout();
                    return new SeeOtherEndPoint('/');
                }
            };
        });
    }

    public function acquireTemporaryCredentials(): string
    {
        $temporaryCredentials = $this->server->getTemporaryCredentials();
        $this->session->getSegment('token')->set('temporary_credentials', serialize($temporaryCredentials));
        return $this->server->getAuthorizationUrl($temporaryCredentials);
    }

    public function authorizeTokenCredentials(string $oauthToken, string $oauthVerifier): void
    {
        $temporaryCredentialsSerialized = $this->session->getSegment('token')->get('temporary_credentials');
        if ($temporaryCredentialsSerialized !== null) {
            $temporaryCredentials = unserialize($temporaryCredentialsSerialized);
            $tokenCredentials = $this->server->getTokenCredentials($temporaryCredentials, $oauthToken, $oauthVerifier);
            $this->session->getSegment('token')->set('temporary_credentials', null);
            $this->session->getSegment('token')->set('credentials', serialize($tokenCredentials));
        }
    }
}