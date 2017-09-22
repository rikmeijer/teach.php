<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ResponseFactory;

class Qr implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }


    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/qr#', $request->getUri()->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        $query = $request->getQueryParams();
        $phpview = $this->resources->phpview('Qr');
        $responseFactory = $this->resources->responseFactory();

        return new class($phpview, $responseFactory, $query) implements ResponseFactory
        {
            private $responseFactory;
            private $phpview;
            private $query;

            public function __construct(\pulledbits\View\File\Template $phpview, \pulledbits\Response\Factory $responseFactory, array $query)
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
                    return $this->responseFactory->make200($this->phpview->capture('qr', ['data' => $this->query['data']]));
                }
            }
        };
    }
}