<?php


namespace rikmeijer\Teach\GUI\Feedback;


class View
{
    private $gui;
    private $phpviewDirectory;

    public function __construct(Feedback $gui, Directory $phpviewDirectory)
    {
        $this->gui = $gui;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleGet(\Psr\Http\Message\ServerRequestInterface $request)
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