<?php


namespace rikmeijer\Teach\GUI\SSO;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\PHPviewEndPoint;

class Profile implements Route
{
    private $phpviewDirectory;
    private $details;

    /**
     * Profile constructor.
     * @param Directory $phpviewDirectory
     * @param array $details
     */
    public function __construct(Directory $phpviewDirectory, array $details)
    {
        $this->phpviewDirectory = $phpviewDirectory;
        $this->details = $details;
    }

    public function handleRequest(ServerRequestInterface $request): RouteEndPoint
    {
        return new PHPviewEndPoint($this->phpviewDirectory->load('profile', ['details' => $this->details]));
    }
}
