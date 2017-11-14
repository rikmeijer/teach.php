<?php namespace rikmeijer\Teach\Routes\Contactmoment;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
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

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/contactmoment/import$#', $uri->getPath()) === 1;
    }

    public function makeResponseFactory(ServerRequestInterface $request): ResponseFactory
    {
        $user = $this->resources->userForToken($this->resources->token());
        if ($user->extra['employee'] === false) {
            return ErrorFactory::makeInstance(403);
        }

        $phpview = $this->resources->phpview('Contactmoment\\Import');
        $responseFactory = $this->resources->responseFactory();

        switch ($request->getMethod()) {
            case 'GET':
                return new GetFactory($phpview, $responseFactory);

            case 'POST':
                $icalReader = $this->resources->iCalReader($request->getParsedBody()['url']);
                $schema = $this->resources->schema();
                return new PostFactory($schema, $phpview, $responseFactory, $icalReader, $user);

            default:
                return $responseFactory->make405('Method not allowed');
        }

    }
}