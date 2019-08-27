<?php


namespace rikmeijer\Teach\GUI\SSO;


use Psr\Http\Message\ServerRequestInterface;
use pulledbits\Router\Route;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\Directory;
use rikmeijer\Teach\GUI\SSO;
use rikmeijer\Teach\PHPviewEndPoint;
use rikmeijer\Teach\User;

class Profile
{
    private $phpviewDirectory;
    private $gui;

    /**
     * Profile constructor.
     * @param Directory $phpviewDirectory
     * @param array $details
     */
    public function __construct(Directory $phpviewDirectory, SSO $gui)
    {
        $this->phpviewDirectory = $phpviewDirectory;
        $this->gui = $gui;
    }

    public function handleRequest(ServerRequestInterface $request): PHPviewEndPoint
    {
        return new PHPviewEndPoint($this->phpviewDirectory->load('profile', ['details' => $this->gui->details()]));
    }
}
