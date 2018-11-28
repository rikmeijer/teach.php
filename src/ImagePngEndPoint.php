<?php namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;
use pulledbits\Router\RouteEndPointDecorator;

class ImagePngEndPoint extends RouteEndPointDecorator
{
    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return parent::respond($psrResponse->withHeader('Content-Type', 'image/png'));
    }
}