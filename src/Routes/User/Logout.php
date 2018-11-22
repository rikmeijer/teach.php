<?php namespace rikmeijer\Teach\Routes\User;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Logout implements RouteEndPoint
{
    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $psrResponse->withStatus('303')->makeWithHeaders(['Location' => '/'], '');
    }
}