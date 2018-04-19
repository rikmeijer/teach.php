<?php namespace rikmeijer\Teach\Routes\SSO;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\SSO;

class CallbackFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $sso;

    public function __construct(SSO $sso)
    {
        $this->sso = $sso;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/sso/callback#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $queryParams = $request->getQueryParams();

        if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
            return new Callback\TokenAuthorizationFactory($this->sso, $queryParams['oauth_token'], $queryParams['oauth_verifier']);
        } else {
            return ErrorFactory::makeInstance(400);
        }
    }
}