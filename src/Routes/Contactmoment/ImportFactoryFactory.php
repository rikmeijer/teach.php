<?php namespace rikmeijer\Teach\Routes\Contactmoment;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\ResponseFactory;
use rikmeijer\Teach\Routes\Contactmoment\Import\GetFactory;
use rikmeijer\Teach\Routes\Contactmoment\Import\PostFactory;

class ImportFactoryFactory implements \pulledbits\Router\ResponseFactoryFactory
{
    private $resources;

    public function __construct(\rikmeijer\Teach\Resources $resources)
    {
        $this->resources = $resources;
    }

    public function matchRequest(ServerRequestInterface $request): bool
    {
        return preg_match('#^/contactmoment/import$#', $request->getUri()->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        $phpview = $this->resources->phpview('Contactmoment\\Import');
        $responseFactory = $this->resources->responseFactory();

        switch ($request->getMethod()) {
            case 'GET':
                return new GetFactory($phpview, $responseFactory);

            case 'POST':
                $icalReader = $this->resources->iCalReader($request->getParsedBody()['url']);
                $schema = $this->resources->schema();
                return new PostFactory($schema, $phpview, $responseFactory, $icalReader);

            default:
                return $responseFactory->make405('Method not allowed');
        }

    }
}