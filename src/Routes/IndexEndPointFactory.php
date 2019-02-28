<?php namespace rikmeijer\Teach\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use pulledbits\Router\RouteEndPoint;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\PHPViewDirectoryFactory;
use rikmeijer\Teach\PHPviewEndPoint;

final class IndexEndPointFactory implements \pulledbits\Router\RouteEndPointFactory
{
    private $useCase;
    private $phpviewDirectory;

    public function __construct(GUI\Index $useCase, PHPViewDirectoryFactory $phpviewDirectoryFactory)
    {
        $this->useCase = $useCase;
        $this->phpviewDirectory = $phpviewDirectoryFactory->make('');
    }

    public function matchUri(UriInterface $uri): bool
    {
        return preg_match('#^/#', $uri->getPath()) === 1;
    }

    public function makeRouteEndPointForRequest(ServerRequestInterface $request): RouteEndPoint
    {
        return new PHPviewEndPoint($this->phpviewDirectory->load('welcome', [
            'modules' => $this->useCase->retrieveModules(),
            'contactmomenten' => $this->useCase->retrieveContactmomenten()
        ]));
    }
}