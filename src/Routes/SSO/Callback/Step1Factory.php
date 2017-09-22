<?php namespace rikmeijer\Teach\Routes\SSO\Callback;

use Aura\Session\Session;
use Avans\OAuth\Web;
use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;

class Step1Factory implements ResponseFactory
{
    private $responseFactory;
    private $session;
    private $server;
    private $oauthToken;
    private $oauthVerifier;

    public function __construct(\pulledbits\Response\Factory $responseFactory, Session $session, Web $server, string $oauthToken, string $oauthVerifier)
    {
        $this->responseFactory = $responseFactory;
        $this->session = $session;
        $this->server = $server;
        $this->oauthToken = $oauthToken;
        $this->oauthVerifier = $oauthVerifier;
    }

    public function makeResponse(): ResponseInterface
    {
        $temporaryCredentialsSerialized = $this->session->getSegment('token')->get('temporary_credentials');
        if ($temporaryCredentialsSerialized !== null) {
            $temporaryCredentials = unserialize($temporaryCredentialsSerialized);
            $tokenCredentials = $this->server->getTokenCredentials($temporaryCredentials, $this->oauthToken, $this->oauthVerifier);
            $this->session->getSegment('token')->set('temporary_credentials', null);
            $this->session->getSegment('token')->set('credentials', serialize($tokenCredentials));
            $this->session->commit();
        }
        return $this->responseFactory->makeWithHeaders(303, ['Location' => '/'], '');
    }
}