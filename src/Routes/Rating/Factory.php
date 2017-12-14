<?php namespace rikmeijer\Teach\Routes\Rating;


use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;

class Factory implements ResponseFactory
{
    private $responseFactory;
    private $phpview;
    private $ratingwaarde;
    private $assets;

    public function __construct(\pulledbits\View\Directory $phpview, \pulledbits\Response\Factory $responseFactory, int $ratingwaarde, array $assets)
    {
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
        $this->ratingwaarde = $ratingwaarde;
        $this->assets = $assets;
    }

    public function makeResponse(): ResponseInterface
    {
        return $this->responseFactory->make200($this->phpview->load('rating')->prepare([
            'ratingwaarde' => $this->ratingwaarde,
            'starData' => $this->assets['star'],
            'unstarData' => $this->assets['unstar']
        ])->capture());
    }
}