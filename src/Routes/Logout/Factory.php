<?php namespace rikmeijer\Teach\Routes\Logout;

use Aura\Session\Session;
use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ResponseFactory;

class Factory implements ResponseFactory
{
    private $session;
    private $responseFactory;

    public function __construct(Session $session, \pulledbits\Response\Factory $responseFactory)
    {
        $this->session = $session;
        $this->responseFactory = $responseFactory;
    }

    public function makeResponse(): ResponseInterface
    {
        if ($this->session->isStarted()) {
            $this->session->getSegment('token')->clear();
            $this->session->clear();
            $this->session->destroy();
        }
        return $this->responseFactory->makeWithHeaders(303, ['Location' => '/'], '');
    }
}