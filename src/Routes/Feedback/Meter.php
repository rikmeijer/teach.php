<?php namespace rikmeijer\Teach\Routes\Feedback;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Contactmoment;

class Meter implements RouteEndPoint
{
    private $phpview;
    private $contactmoment;

    public function __construct(\pulledbits\View\Template $phpview, Contactmoment $contactmoment)
    {
        $this->phpview = $phpview;
        $this->contactmoment = $contactmoment;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $this->phpview->prepareAsResponse($psrResponse, ['contactmoment' => $this->contactmoment]);
    }
}