<?php namespace rikmeijer\Teach\Routes\SSO\Authorize;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\SSO;

class TemporaryTokenCredentialsAcquisitionFactory implements RouteEndPoint
{
    private $sso;

    public function __construct(SSO $sso)
    {
        $this->sso = $sso;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $this->sso->acquireTemporaryCredentials();
        exit;
    }
}