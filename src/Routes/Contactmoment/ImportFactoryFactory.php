<?php namespace rikmeijer\Teach\Routes\Contactmoment;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\Routes\Contactmoment\Import\GetFactory;
use rikmeijer\Teach\Routes\Contactmoment\Import\PostFactory;

class ImportFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $resources;

    public function __construct(callable $user, \rikmeijer\Teach\Resources $resources)
    {
        $this->user = $user();
        $this->resources = $resources;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/contactmoment/import$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request) : RouteEndPoint
    {
        if ($this->user->extra['employee'] === false) {
            return ErrorFactory::makeInstance('403');
        }

        $viewDirectory = $this->resources->phpviewDirectory('contactmoment');

        switch ($request->getMethod()) {
            case 'GET':
                return new GetFactory($viewDirectory->load('import'));

            case 'POST':
                $icalReader = $this->resources->iCalReader($request->getParsedBody()['url']);
                $schema = $this->resources->schema();
                return new PostFactory($schema, $viewDirectory->load('imported'), $icalReader, $this->user);

            default:
                return ErrorFactory::makeInstance('405');
        }

    }
}