<?php namespace rikmeijer\Teach\Routes\Feedback\Supply;

use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Form implements RouteEndPoint
{
    private $phpview;
    private $rating;
    private $explanation;

    public function __construct(\pulledbits\View\Template $phpview, string $rating, string $explanation)
    {
        $this->phpview = $phpview;
        $this->rating = $rating;
        $this->explanation = $explanation;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $this->phpview->prepareAsResponse($psrResponse, ['rating' => $this->rating, 'explanation' => $this->explanation]);
    }
}