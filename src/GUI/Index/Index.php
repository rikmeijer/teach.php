<?php


namespace rikmeijer\Teach\GUI\Index;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\View\Directory;
use rikmeijer\Teach\PHPviewEndPoint;

class Index
{
    private $phpviewDirectory;

    public function __construct(Directory $phpviewDirectory)
    {
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(ServerRequestInterface $request): PHPviewEndPoint
    {
        return new PHPviewEndPoint($this->phpviewDirectory->load('welcome'));
    }
}
