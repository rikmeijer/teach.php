<?php namespace rikmeijer\Teach\Routes\SSO;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Routes\SSO\Callback\Step1Factory;

class CallbackFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/sso/callback#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $session = $this->resources->session();
        $server = $this->resources->sso();

        $queryParams = $request->getQueryParams();

        if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
            return new Step1Factory($session, $server, $queryParams['oauth_token'], $queryParams['oauth_verifier']);
        } else {
            return new Step2Factory($session, $server);
        }
    }
}