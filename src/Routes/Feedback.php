<?php namespace rikmeijer\Teach\Routes;

class Feedback implements \pulledbits\Router\Handler
{
    private $resources;
    private $phpview;

    public function __construct(\rikmeijer\Teach\Resources $resources) {
        $this->resources = $resources;
        $this->phpview = $this->resources->phpview(__DIR__ . DIRECTORY_SEPARATOR . str_replace(__NAMESPACE__ . NAMESPACE_SEPARATOR,"",__CLASS__));
    }

    public function handleRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $schema = $this->resources->schema();
        $contactmoment = $schema->readFirst('contactmoment', [], ['id' => $request->getAttribute('contactmomentIdentifier')]);
        return $this->resources->respond(200, $this->phpview->capture('feedback', ['contactmoment' => $contactmoment]));
    }
}