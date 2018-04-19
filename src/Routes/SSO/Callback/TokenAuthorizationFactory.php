<?php namespace rikmeijer\Teach\Routes\SSO\Callback;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\SSO;

class TokenAuthorizationFactory implements RouteEndPoint
{
    private $sso;
    private $oauthToken;
    private $oauthVerifier;

    public function __construct(SSO $sso, string $oauthToken, string $oauthVerifier)
    {
        $this->sso = $sso;
        $this->oauthToken = $oauthToken;
        $this->oauthVerifier = $oauthVerifier;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $this->sso->authorizeTokenCredentials($this->oauthToken, $this->oauthVerifier);
        return $psrResponse->withStatus('303')->withHeader('Location', '/');
    }
}