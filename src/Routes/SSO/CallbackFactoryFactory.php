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
        return (array_key_exists('oauth_token', $_GET) && array_key_exists('oauth_verifier', $_GET)) || preg_match('#^/sso/callback#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        syslog(LOG_DEBUG, 'OAUTH Callback');
        $session = $this->resources->session();
        $server = $this->resources->sso();

        $queryParams = $request->getQueryParams();

        $sessionToken = $this->session->getSegment('token');
        if (array_key_exists('oauth_token', $queryParams) && array_key_exists('oauth_verifier', $queryParams)) {
            syslog(LOG_DEBUG, 'Step 1: token/verifier : ' . $queryParams['oauth_token'] .'/' . $queryParams['oauth_verifier']);
            return new Step1Factory($sessionToken, $server, $queryParams['oauth_token'], $queryParams['oauth_verifier']);
        } else {
            syslog(LOG_DEBUG, 'No oauth token or verifier exists, must be step two then: ');
            return new Step2Factory($sessionToken, $server);
        }
    }
}