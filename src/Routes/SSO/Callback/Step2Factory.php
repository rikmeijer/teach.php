<?php namespace rikmeijer\Teach\Routes\SSO\Callback;

use Aura\Session\Session;
use Avans\OAuth\Web;
use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;

class Step2Factory implements RouteEndPoint
{
    private $session;
    private $server;

    public function __construct(Session $session, Web $server)
    {
        $this->session = $session;
        $this->server = $server;
    }

    public function respond(\pulledbits\Response\Factory $psrResponseFactory): ResponseInterface
    {
        $temporaryCredentials = $this->server->getTemporaryCredentials();
        $this->session->getSegment('token')->set('temporary_credentials', serialize($temporaryCredentials));
        $this->server->authorize($temporaryCredentials);
        exit;
    }
}