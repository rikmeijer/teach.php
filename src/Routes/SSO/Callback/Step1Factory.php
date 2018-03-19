<?php namespace rikmeijer\Teach\Routes\SSO\Callback;

use Aura\Session\Session;
use Avans\OAuth\Web;
use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Step1Factory implements RouteEndPoint
{
    private $sessionToken;
    private $server;
    private $oauthToken;
    private $oauthVerifier;

    public function __construct(Session $sessionToken, Web $server, string $oauthToken, string $oauthVerifier)
    {
        $this->sessionToken = $sessionToken;
        $this->server = $server;
        $this->oauthToken = $oauthToken;
        $this->oauthVerifier = $oauthVerifier;
    }

    public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
    {
        $temporaryCredentialsSerialized = $this->sessionToken->get('temporary_credentials');
        syslog(LOG_DEBUG, 'Temporary credentials (before retrieving actual token): ' . var_export($temporaryCredentialsSerialized, true));
        if ($temporaryCredentialsSerialized !== null) {
            $temporaryCredentials = unserialize($temporaryCredentialsSerialized);
            $tokenCredentials = $this->server->getTokenCredentials($temporaryCredentials, $this->oauthToken, $this->oauthVerifier);
            syslog(LOG_DEBUG, 'Credentials: ' . var_export($tokenCredentials, true));
            $this->sessionToken->set('temporary_credentials', null);
            $this->sessionToken->set('credentials', serialize($tokenCredentials));
        }
        return $psrResponseFactory->makeWithHeaders(303, ['Location' => '/'], '');
    }
}