<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\Routes\Index\Factory;

class IndexFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $userCallback;
    private $schema;
    private $phpviewDirectory;

    public function __construct(callable $userCallback, Schema $schema, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->userCallback = $userCallback;
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        $user = call_user_func($this->userCallback);
        if ($user->extra['employee'] === false) {
            return ErrorFactory::makeInstance('403');
        }
        return new Factory($this->schema, $this->phpviewDirectory->load('welcome'));
    }
}