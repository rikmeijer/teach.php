<?php namespace rikmeijer\Teach\Routes\Qr;

use Psr\Http\Message\ResponseInterface;
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

    public function respond(\pulledbits\Response\Factory $psrResponseFactory): ResponseInterface
    {
        if (array_key_exists('data', $this->query) === false) {
            return $psrResponseFactory->make400('Query incomplete');
        } elseif ($this->query['data'] === null) {
            return $psrResponseFactory->make400('Query data incomplete');
        } else {
            return $psrResponseFactory->make200($this->phpview->load('qr')->prepare(['data' => $this->query['data']])->capture());
        }
    }
}