<?php namespace rikmeijer\Teach\Routes;

class Qr implements \pulledbits\Router\Handler
{
    private $resources;
    private $phpview;

    public function __construct(\rikmeijer\Teach\Resources $resources, \pulledbits\View\File\Template $phpview) {
        $this->resources = $resources;
        $this->phpview = $phpview;
    }

    public function handleRequest(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $query = $request->getQueryParams();
        if (array_key_exists('data', $query) === false) {
            return $this->resources->respond(400, 'Query incomplete');
        } elseif ($query['data'] === null) {
            return $this->resources->respond(400, 'Query data incomplete');
        } else {
            return $this->resources->respondWithHeaders(200, ['Content-Type' => 'image/png'], $this->phpview->capture('qr', ['data' => $query['data']]));
        }
    }
}