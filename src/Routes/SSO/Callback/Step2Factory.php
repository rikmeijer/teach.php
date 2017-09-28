<?php namespace rikmeijer\Teach\Routes\SSO\Callback;

use Aura\Session\Session;
use Avans\OAuth\Web;
use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;

class Step2Factory implements ResponseFactory
{
    private $responseFactory;
    private $session;
    private $server;
    private $oauthToken;
    private $oauthVerifier;

    public function __construct(\pulledbits\Response\Factory $responseFactory, Session $session, Web $server)
    {
        $this->responseFactory = $responseFactory;
        $this->session = $session;
        $this->server = $server;
    }

    public function makeResponse(): ResponseInterface
    {
        $temporaryCredentials = $this->server->getTemporaryCredentials();
        $this->session->getSegment('token')->set('temporary_credentials', serialize($temporaryCredentials));
        $this->server->authorize($temporaryCredentials);
        exit;
    }
}