<?php


namespace rikmeijer\Teach\GUI\Feedback;

use pulledbits\Router\Route;
use pulledbits\View\Directory;
use rikmeijer\Teach\GUI\Feedback;

class Supply implements Route
{
    private $gui;
    private $phpviewDirectory;

    public function __construct(Feedback $gui, Directory $phpviewDirectory)
    {
        $this->gui = $gui;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(\Psr\Http\Message\ServerRequestInterface $request): \pulledbits\Router\RouteEndPoint
    {
        switch ($request->getMethod()) {
            case 'GET':
                return $this->handleGet($request);

            case 'POST':
                return $this->handlePost($request);
            default:
                return \pulledbits\Router\ErrorFactory::makeInstance('405');
        }
    }

    private function handleGet(\Psr\Http\Message\ServerRequestInterface $request): \pulledbits\Router\RouteEndPoint
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

        return new \rikmeijer\Teach\PHPviewEndPoint($this->phpviewDirectory->load(
            'supply',
            ['rating' => $rating, 'explanation' => $ipRating->inhoud]
        ));
    }

    private function handlePost(\Psr\Http\Message\ServerRequestInterface $request): \pulledbits\Router\RouteEndPoint
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
