<?php namespace rikmeijer\Teach\Routes\Contactmoment;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Contactmoment\Import\GetFactory;
use rikmeijer\Teach\Routes\Contactmoment\Import\PostFactory;
use rikmeijer\Teach\User;

class ImportFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $user;
    private $phpviewDirectory;

    public function __construct(User $user, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->user = $user;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('contactmoment');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/contactmoment/import$#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request) : RouteEndPoint
    {
        if ($this->user->isEmployee() === false) {
            return ErrorFactory::makeInstance('403');
        }

        switch ($request->getMethod()) {
            case 'GET':
                return new GetFactory($this->phpviewDirectory->load('import'));

            case 'POST':
                return new PostFactory($this->phpviewDirectory->load('imported'), $this->user);

            default:
                return ErrorFactory::makeInstance('405');
        }

    }
}