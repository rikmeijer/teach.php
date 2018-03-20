<?php namespace rikmeijer\Teach\Routes\Contactmoment;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Contactmoment\Import\GetFactory;
use rikmeijer\Teach\Routes\Contactmoment\Import\PostFactory;

class ImportFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $schema;
    private $icalReader;
    private $userCallback;
    private $phpviewDirectory;

    public function __construct(Schema $schema, \ICal $icalReader, callable $userCallback, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->schema = $schema;
        $this->icalReader = $icalReader;
        $this->userCallback = $userCallback;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('contactmoment');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/contactmoment/import$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request) : RouteEndPoint
    {
        $user = call_user_func($this->userCallback);
        if ($user->extra['employee'] === false) {
            return ErrorFactory::makeInstance('403');
        }

        switch ($request->getMethod()) {
            case 'GET':
                return new GetFactory($this->phpviewDirectory->load('import'));

            case 'POST':
                $this->icalReader->initURL($request->getParsedBody()['url']);
                return new PostFactory($this->schema, $this->phpviewDirectory->load('imported'), $this->icalReader, $user);

            default:
                return ErrorFactory::makeInstance('405');
        }

    }
}