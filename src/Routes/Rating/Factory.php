<?php namespace rikmeijer\Teach\Routes\Rating;


use Psr\Http\Message\ResponseInterface;
use pulledbits\ActiveRecord\Record;
use pulledbits\Router\ResponseFactory;

class Factory implements ResponseFactory
{
    private $responseFactory;
    private $phpview;
    private $contactmomentrating;
    private $assets;

    public function __construct(\pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, Record $contactmomentrating, array $assets)
    {
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
        $this->contactmomentrating = $contactmomentrating;
        $this->assets = $assets;
    }

    public function makeResponse(): ResponseInterface
    {
        return $this->responseFactory->make200($this->phpview->capture('rating', [
            'rating' => $this->contactmomentrating->waarde,
            'starData' => $this->assets['star'],
            'unstarData' => $this->assets['unstar']
        ]));
    }
}