<?php namespace rikmeijer\Teach\Routes;

class Index implements \pulledbits\Router\Handler
{
    private $resources;
    private $responseFactory;
    private $phpview;

    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview, \rikmeijer\Teach\Response $responseFactory) {
        $this->resources = $resources;
        $this->responseFactory = $responseFactory;
        $this->phpview = $phpview;
    }

    public function handleRequest(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $schema = $this->resources->schema();
        return $this->responseFactory->make(200, $this->phpview->capture('welcome', ['modules' => $schema->read('module', [], []), 'contactmomenten' => $schema->read('contactmoment_vandaag', [], [])]));
    }
}