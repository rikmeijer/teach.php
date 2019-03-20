<?php


namespace rikmeijer\Teach\GUI\Index;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\PHPviewEndPoint;

class Index implements Route
{
    private $phpviewDirectory;

    public function __construct(Directory $phpviewDirectory)
    {
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(ServerRequestInterface $request): RouteEndPoint
    {
        return new PHPviewEndPoint($this->phpviewDirectory->load('welcome'));
    }
}
