<?php

namespace rikmeijer\Teach\GUI;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Bootstrap\Bootstrap;
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
        $router->addRoute(
            '/sso/authorize',
            function (ServerRequestInterface $request, callable $next): ResponseInterface {
                return $this->seeOther($next($request), $this->user->acquireTemporaryCredentials());
            }
        );
        $router->addRoute(
            '/sso/callback',
            function (ServerRequestInterface $request, callable $next): ResponseInterface {
                $queryParams = $request->getQueryParams();

                if (array_key_exists('oauth_token', $queryParams) === false) {
                    return ErrorFactory::makeInstance(400);
                } elseif (array_key_exists('oauth_verifier', $queryParams) === false) {
                    return ErrorFactory::makeInstance(400);
                } else {
                    $this->user->authorizeTokenCredentials(
                        $queryParams['oauth_token'],
                        $queryParams['oauth_verifier']
                    );
                    return $this->seeOther($next($request), '/');
                }
            }
        );
        $router->addRoute('/logout',
            function (ServerRequestInterface $request, callable $next): ResponseInterface {
                $this->user->logout();
                return $this->seeOther($next($request), '/');
            });
    }

    private function seeOther(ResponseInterface $psrResponse, string $location): ResponseInterface
    {
        return $psrResponse->withStatus('303')->withHeader('Location', $location);
    }
}
