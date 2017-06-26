<?php namespace rikmeijer\Teach\Routes;

class Qr implements \pulledbits\Router\Handler
{
    private $resources;
    public function __construct(\rikmeijer\Teach\Resources $resources) {
        $this->resources = $resources;
    }

    public function handleRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $query = $request->getQueryParams();
        if (array_key_exists('data', $query) === false) {
            return $this->resources->respond(400, 'Query incomplete');
        } elseif ($query['data'] === null) {
            return $this->resources->respond(400, 'Query data incomplete');
        } else {
            return $this->resources->respondWithHeaders(200, ['Content-Type' => 'image/png'], $this->resources->phpview(__DIR__ . DIRECTORY_SEPARATOR . str_replace(__NAMESPACE__ . NAMESPACE_SEPARATOR,"",__CLASS__))->capture('qr', ['data' => $query['data']]));
        }
    }
}