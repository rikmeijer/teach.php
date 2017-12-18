<?php namespace rikmeijer\Teach\Routes\Qr;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;
use pulledbits\Router\RouteEndPoint;

class Factory implements RouteEndPoint
{
    private $phpview;
    private $query;

    public function __construct(\pulledbits\View\Directory $phpview, array $query)
    {
        $this->phpview = $phpview;
        $this->query = $query;
    }

    public function respond(ResponseFactory $psrResponseFactory): ResponseInterface
    {
        if (array_key_exists('data', $this->query) === false) {
            return $psrResponseFactory->make('400', 'Query incomplete');
        } elseif ($this->query['data'] === null) {
            return $psrResponseFactory->make('400', 'Query data incomplete');
        } else {
            return $psrResponseFactory->make('200', $this->phpview->load('qr')->prepare(['data' => $this->query['data']])->capture());
        }
    }
}