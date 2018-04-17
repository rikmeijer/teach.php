<?php namespace rikmeijer\Teach\Routes\Feedback;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Factory implements RouteEndPoint
{
    private $phpview;
    private $contactmoment;

    public function __construct(\pulledbits\View\Template $phpview, Record $contactmoment)
    {
        $this->phpview = $phpview;
        $this->contactmoment = $contactmoment;
    }

    public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
    {
        return $psrResponseFactory->makeWithTemplate('200', $this->phpview->prepare(['contactmoment' => $this->contactmoment]));
    }
}