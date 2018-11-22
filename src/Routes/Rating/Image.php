<?php namespace rikmeijer\Teach\Routes\Rating;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Image implements RouteEndPoint
{
    private $phpview;

    public function __construct(\pulledbits\View\Template $phpview)
    {
        $this->phpview = $phpview;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {

        return $this->phpview->prepareAsResponse($psrResponse->withHeader('Content-Type', 'image/png'));
    }
}