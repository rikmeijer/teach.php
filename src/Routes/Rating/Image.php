<?php namespace rikmeijer\Teach\Routes\Rating;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use rikmeijer\Teach\PHPviewEndPoint;

class Image extends PHPviewEndPoint
{
    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {

        return parent::respond($psrResponse->withHeader('Content-Type', 'image/png'));
    }
}