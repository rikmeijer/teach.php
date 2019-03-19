<?php namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;

class SeeOtherEndPoint implements RouteEndPoint
{
    public function __construct(string $location)
    {
        $this->location = $location;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $psrResponse->withStatus('303')->withHeader('Location', $this->location);
    }
}
