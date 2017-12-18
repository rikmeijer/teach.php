<?php namespace rikmeijer\Teach\Routes;

use League\OAuth1\Client\Server\User;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ServerRequestInterface;
use pulledbits\ActiveRecord\Schema;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\Routes\Index\Factory;

class IndexFactoryFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $user;
    private $schema;
    private $phpviewDirectory;

    public function __construct(User $user, Schema $schema, Directory $phpviewDirectory)
    {
        $this->user = $user;
        $this->schema = $schema;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        if ($this->user->extra['employee'] === false) {
            return ErrorFactory::makeInstance('403');
        }
        return new Factory($this->schema, $this->phpviewDirectory->load('welcome'));
    }
}