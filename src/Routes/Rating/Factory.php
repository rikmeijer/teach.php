<?php namespace rikmeijer\Teach\Routes\Rating;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Factory implements RouteEndPoint
{
    private $phpview;
    private $ratingwaarde;
    private $assets;

    public function __construct(\pulledbits\View\Template $phpview, int $ratingwaarde, array $assets)
    {
        $this->phpview = $phpview;
        $this->ratingwaarde = $ratingwaarde;
        $this->assets = $assets;
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $this->phpview->prepareAsResponse($psrResponse, [
            'ratingwaarde' => $this->ratingwaarde,
            'starData' => $this->assets['star'],
            'unstarData' => $this->assets['unstar']
        ]);
    }
}