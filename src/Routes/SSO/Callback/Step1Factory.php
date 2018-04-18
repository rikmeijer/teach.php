<?php namespace rikmeijer\Teach\Routes\SSO\Callback;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\User;

class Step1Factory implements RouteEndPoint
{
    private $user;
    private $oauthToken;
    private $oauthVerifier;

    public function __construct(User $user, string $oauthToken, string $oauthVerifier)
    {
        $this->user = $user;
        $this->oauthToken = $oauthToken;
        $this->oauthVerifier = $oauthVerifier;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $this->user->authorizeTokenCredentials($this->oauthToken, $this->oauthVerifier);
        return $psrResponse->withStatus('303')->withHeader('Location', '/');
    }
}