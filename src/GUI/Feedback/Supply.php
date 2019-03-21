<?php


namespace rikmeijer\Teach\GUI\Feedback;

use pulledbits\ActiveRecord\Entity;
use pulledbits\Router\ErrorFactory;
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
        $contactmoment = $this->gui->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
        if ($contactmoment->id === null) {
            return \pulledbits\Router\ErrorFactory::makeInstance('404');
        }

        switch ($request->getMethod()) {
            case 'GET':
                return $this->handleGet($contactmoment->findRatingByIP(($request->getServerParams())['REMOTE_ADDR']), $request->getQueryParams());

            case 'POST':
                return $this->handlePost($contactmoment, ($request->getServerParams())['REMOTE_ADDR'], $request->getParsedBody());
            default:
                return \pulledbits\Router\ErrorFactory::makeInstance('405');
        }
    }

    private function handleGet(Entity $ipRating, array $query): \pulledbits\Router\RouteEndPoint
    {
        if (array_key_exists('rating', $query)) {
            $rating = $query['rating'];
        } else {
            $rating = $ipRating->waarde;
        }

        return new \rikmeijer\Teach\PHPviewEndPoint(
            $this->phpviewDirectory->load(
                'feedback/supply',
                [
                    'rating' => $rating,
                    'explanation' => $ipRating->inhoud
                ]
            )
        );
    }

    private function handlePost(\rikmeijer\Teach\Contactmoment $contactmoment, string $remoteAddress, array $parsedBody): \pulledbits\Router\RouteEndPoint
    {
        if ($this->gui->verifyCSRFToken($parsedBody['__csrf_value']) === false) {
            return ErrorFactory::makeInstance('403');
        }
        $contactmoment->rate($remoteAddress, $parsedBody['rating'], $parsedBody['explanation']);
        return new \rikmeijer\Teach\PHPviewEndPoint($this->phpviewDirectory->load('feedback/processed'));
    }
}
