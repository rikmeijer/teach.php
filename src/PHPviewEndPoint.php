<?php
namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;

class PHPviewEndPoint implements RouteEndPoint
{
    private $phpview;

    public function __construct(\pulledbits\View\Template $phpview)
    {
        $this->phpview = $phpview;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $this->phpview->prepareAsResponse($psrResponse);
    }

}