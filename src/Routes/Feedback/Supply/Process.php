<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Process implements RouteEndPoint
{
    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $psrResponse->withBody(stream_for('Dankje!'));
    }
}