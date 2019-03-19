<?php

namespace rikmeijer\Teach\GUI;

use Avans\OAuth\Web;
use League\OAuth1\Client\Credentials\TemporaryCredentials;
use League\OAuth1\Client\Credentials\TokenCredentials;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Bootstrap;
use rikmeijer\Teach\ClosureEndPoint;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\SeeOtherEndPoint;
use rikmeijer\Teach\User;

class SSO implements GUI
{
    private $session;

    /**
     * @var User
     */
    private $user;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->user = $bootstrap->resource('user');
        $this->session = $bootstrap->resource('session');
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

                    if (array_key_exists('oauth_token', $queryParams) === false) {
                        return ErrorFactory::makeInstance(400);
                    } elseif (array_key_exists('oauth_verifier', $queryParams) === false) {
                        return ErrorFactory::makeInstance(400);
                    } else {
                        $this->gui->authorizeTokenCredentials(
                            $queryParams['oauth_token'],
                            $queryParams['oauth_verifier']
                        );
                        return new SeeOtherEndPoint('/');
                    }
                }
            };
        });
        $router->addRoute('^/logout', function (): Route {
            return new class($this) implements Route
            {
                private $gui;

                public function __construct(\rikmeijer\Teach\GUI\SSO $gui)
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
        return $this->user->acquireTemporaryCredentials();
    }

    public function authorizeTokenCredentials(string $oauthToken, string $oauthVerifier): void
    {
        $this->user->authorizeTokenCredentials($oauthToken, $oauthVerifier);
    }
    public function logout(): void
    {
        $this->user->logout();
    }
}
