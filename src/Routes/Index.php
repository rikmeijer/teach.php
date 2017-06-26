<?php namespace rikmeijer\Teach\Routes;

class Index implements \pulledbits\Router\Handler
{
    private $resources;
    private $phpview;

    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview) {
        $this->resources = $resources;
        $this->phpview = $phpview;
    }

    public function handleRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $schema = $this->resources->schema();
        return $this->resources->respond(200, $this->phpview->capture('welcome', ['modules' => $schema->read('module', [], []), 'contactmomenten' => $schema->read('contactmoment_vandaag', [], [])]));
    }
}