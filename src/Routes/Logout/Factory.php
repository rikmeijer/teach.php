<?php namespace rikmeijer\Teach\Routes\Logout;

use Aura\Session\Session;
use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Factory implements RouteEndPoint
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
    {
        if ($this->session->isStarted()) {
            $this->session->getSegment('token')->clear();
            $this->session->clear();
            $this->session->destroy();
        }
        return $psrResponseFactory->changeStatusCode('303')->makeWithHeaders(['Location' => '/'], '');
    }
}