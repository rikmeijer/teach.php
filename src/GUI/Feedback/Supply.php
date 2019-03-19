<?php


namespace rikmeijer\Teach\GUI\Feedback;


use pulledbits\View\Directory;
use rikmeijer\Teach\GUI\Feedback;

class Supply
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
            return \pulledbits\Router\ErrorFactory::makeInstance('404');
        }

        $ipRating = $contactmoment->findRatingByIP(($request->getServerParams())['REMOTE_ADDR']);

        $query = $request->getQueryParams();
        if (array_key_exists('rating', $query)) {
            $rating = $query['rating'];
        } else {
            $rating = $ipRating->waarde;
        }

        return new \rikmeijer\Teach\PHPviewEndPoint($this->phpviewDirectory->load('supply', ['rating' => $rating, 'explanation' => $ipRating->inhoud]));
    }

    public function handlePost(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $contactmoment = $this->gui->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
        if ($contactmoment->id === null) {
            return \pulledbits\Router\ErrorFactory::makeInstance('404');
        }

        $parsedBody = $request->getParsedBody();
        if ($this->gui->verifyCSRFToken($parsedBody['__csrf_value']) === false) {
            return ErrorFactory::makeInstance('403');
        }
        $contactmoment->rate($_SERVER['REMOTE_ADDR'], $parsedBody['rating'], $parsedBody['explanation']);
        return new \rikmeijer\Teach\PHPviewEndPoint($this->phpviewDirectory->load('processed'));

    }

}