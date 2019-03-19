<?php


namespace rikmeijer\Teach\GUI\Feedback;


use pulledbits\Router\RouteEndPoint;

class View
{
    private $gui;
    private $phpviewDirectory;

    public function __construct(Feedback $gui, Directory $phpviewDirectory)
    {
        $this->gui = $gui;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(\Psr\Http\Message\ServerRequestInterface $request) : RouteEndPoint
    {
        $contactmoment = $this->gui->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
        if ($contactmoment->id === null) {
            return \pulledbits\Router\ErrorFactory::makeInstance(404);
        }
        return new \rikmeijer\Teach\PHPviewEndPoint($this->phpviewDirectory->load('feedback', [
            'contactmoment' => $contactmoment
        ]));
    }
}