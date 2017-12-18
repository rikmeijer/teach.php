<?php namespace rikmeijer\Teach\Routes\Rating;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Factory implements RouteEndPoint
{
    private $phpview;
    private $ratingwaarde;
    private $assets;

    public function __construct(\pulledbits\View\Directory $phpview, int $ratingwaarde, array $assets)
    {
        $this->phpview = $phpview;
        $this->ratingwaarde = $ratingwaarde;
        $this->assets = $assets;
    }

    public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
    {
        return $psrResponseFactory->make('200', $this->phpview->load('rating')->prepare([
            'ratingwaarde' => $this->ratingwaarde,
            'starData' => $this->assets['star'],
            'unstarData' => $this->assets['unstar']
        ])->capture());
    }
}