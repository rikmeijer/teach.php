<?php namespace rikmeijer\Teach\Routes\SSO\Callback;

use Avans\OAuth\Web;
use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Step2Factory implements RouteEndPoint
{
    private $sessionToken;
    private $server;

    public function __construct(Segment $sessionToken, Web $server)
    {
        $this->sessionToken = $sessionToken;
        $this->server = $server;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        $temporaryCredentials = $this->server->getTemporaryCredentials();
        $this->sessionToken->set('temporary_credentials', serialize($temporaryCredentials));
        $this->server->authorize($temporaryCredentials);
        exit;
    }
}