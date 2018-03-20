<?php namespace rikmeijer\Teach\Routes\SSO;

use Aura\Session\Session;
use League\OAuth1\Client\Server\Server;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Routes\SSO\Callback\Step1Factory;

class CallbackFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $session;
    private $server;

    public function __construct(Session $session, Server $server)
    {
        $this->session = $session;
        $this->server = $server;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/sso/callback#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $queryParams = $request->getQueryParams();

        $sessionToken = $this->session->getSegment('token');
        if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
            return new Step1Factory($sessionToken, $this->server, $queryParams['oauth_token'], $queryParams['oauth_verifier']);
        } else {
            return new Step2Factory($sessionToken, $this->server);
        }
    }
}