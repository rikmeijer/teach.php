<?php

namespace rikmeijer\Teach\GUI;

use pulledbits\Router\Route;
use \pulledbits\Bootstrap\Bootstrap;
use rikmeijer\Teach\ClosureEndPoint;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\User;

class SSO implements GUI
{
    /**
     * @var User
     */
    private $user;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->user = $bootstrap->resource('user');
    }

    public function addRoutesToRouter(\pulledbits\Router\Router $router): void
    {
        $router->addRoute('^/sso/authorize', function (): Route {
            return new SSO\Authorize($this);
        });
        $router->addRoute('^/sso/callback', function (): Route {
            return new SSO\Authorized($this);
        });
        $router->addRoute('^/logout', function (): Route {
            return new SSO\Logout($this);
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
