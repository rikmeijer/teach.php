<?php namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;

class ImagePngEndPoint implements RouteEndPoint
{
    private $wrappedEndPoint;

    public function __construct(RouteEndPoint $wrappedEndPoint)
    {
        $this->wrappedEndPoint = $wrappedEndPoint;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $this->wrappedEndPoint->respond($psrResponse->withHeader('Content-Type', 'image/png'));
    }
}