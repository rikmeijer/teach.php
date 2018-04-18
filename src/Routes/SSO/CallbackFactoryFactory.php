<?php namespace rikmeijer\Teach\Routes\SSO;

use Aura\Session\Segment;
use Aura\Session\Session;
use League\OAuth1\Client\Server\Server;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Routes\SSO\Callback\Step1Factory;

class CallbackFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $sessionToken;
    private $server;

    public function __construct(Segment $sessionToken, Server $server)
    {
        $this->sessionToken = $sessionToken;
        $this->server = $server;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/sso/callback#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $queryParams = $request->getQueryParams();

        if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
            return new Step1Factory($this->sessionToken, $this->server, $queryParams['oauth_token'], $queryParams['oauth_verifier']);
        } else {
            return new Step2Factory($this->sessionToken, $this->server);
        }
    }
}