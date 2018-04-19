<?php namespace rikmeijer\Teach\Routes\SSO;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\User;

class CallbackFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/sso/callback#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $queryParams = $request->getQueryParams();

        if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
            return new Callback\TokenAuthorizationFactory($this->user, $queryParams['oauth_token'], $queryParams['oauth_verifier']);
        } else {
            return ErrorFactory::makeInstance(400);
        }
    }
}