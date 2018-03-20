<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Index\Factory;
use rikmeijer\Teach\User;

class IndexFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $user;
    private $schema;
    private $phpviewDirectory;

    public function __construct(User $user, Schema $schema, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->user = $user;
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        if ($this->user->isEmployee() === false) {
            return ErrorFactory::makeInstance('403');
        }
        return new Factory($this->schema, $this->phpviewDirectory->load('welcome'));
    }
}