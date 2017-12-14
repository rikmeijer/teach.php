<?php namespace rikmeijer\Teach\Routes\Qr;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\ResponseFactory;

class Factory implements ResponseFactory
{
    private $responseFactory;
    private $phpview;
    private $query;

    public function __construct(\pulledbits\View\Directory $phpview, \pulledbits\Response\Factory $responseFactory, array $query)
    {
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
        $this->query = $query;
    }

    public function makeResponse(): ResponseInterface
    {
        if (array_key_exists('data', $this->query) === false) {
            return $this->responseFactory->make400('Query incomplete');
        } elseif ($this->query['data'] === null) {
            return $this->responseFactory->make400('Query data incomplete');
        } else {
            return $this->responseFactory->make200($this->phpview->load('qr')->prepare(['data' => $this->query['data']])->capture());
        }
    }
}