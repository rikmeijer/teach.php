<?php namespace rikmeijer\Teach\Routes\SSO;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\SSO;

class AuthorizeFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $sso;

    public function __construct(SSO $sso)
    {
        $this->sso = $sso;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/sso/authorize#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        return new Authorize\TemporaryTokenCredentialsAcquisitionFactory($this->sso);
    }
}