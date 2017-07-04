<?php namespace rikmeijer\Teach\Routes;

class Feedback implements \pulledbits\Router\Handler
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
        $schema = $this->resources->schema();
        $contactmoment = $schema->readFirst('contactmoment', [], ['id' => $request->getAttribute('contactmomentIdentifier')]);
        return $this->responseFactory->make(200, $this->phpview->capture('feedback', ['contactmoment' => $contactmoment]));
    }
}