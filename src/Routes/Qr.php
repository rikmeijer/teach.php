<?php namespace rikmeijer\Teach\Routes;

class Qr implements \pulledbits\Router\Handler
{
    private $resources;
    private $responseFactory;
    private $phpview;

    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory) {
        $this->resources = $resources;
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
    }

    public function handleRequest(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $query = $request->getQueryParams();
        if (array_key_exists('data', $query) === false) {
            return $this->responseFactory->make400('Query incomplete');
        } elseif ($query['data'] === null) {
            return $this->responseFactory->make400('Query data incomplete');
        } else {
            return $this->responseFactory->make200($this->phpview->capture('qr', ['data' => $query['data']]));
        }
    }
}