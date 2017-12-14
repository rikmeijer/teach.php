<?php namespace rikmeijer\Teach\Routes\SSO\Callback;

use Aura\Session\Session;
use Avans\OAuth\Web;
use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;

class Step1Factory implements RouteEndPoint
{
    private $session;
    private $server;
    private $oauthToken;
    private $oauthVerifier;

    public function __construct(Session $session, Web $server, string $oauthToken, string $oauthVerifier)
    {
        $this->session = $session;
        $this->server = $server;
        $this->oauthToken = $oauthToken;
        $this->oauthVerifier = $oauthVerifier;
    }

    public function respond(\pulledbits\Response\Factory $psrResponseFactory): ResponseInterface
    {
        $temporaryCredentialsSerialized = $this->session->getSegment('token')->get('temporary_credentials');
        if ($temporaryCredentialsSerialized !== null) {
            $temporaryCredentials = unserialize($temporaryCredentialsSerialized);
            $tokenCredentials = $this->server->getTokenCredentials($temporaryCredentials, $this->oauthToken, $this->oauthVerifier);
            $this->session->getSegment('token')->set('temporary_credentials', null);
            $this->session->getSegment('token')->set('credentials', serialize($tokenCredentials));
        }
        return $psrResponseFactory->makeWithHeaders(303, ['Location' => '/'], '');
    }
}