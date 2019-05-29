<?php


namespace rikmeijer\Teach\GUI\Feedback;

use pulledbits\ActiveRecord\Entity;
use pulledbits\Router\ErrorFactory;
use pulledbits\Router\Route;
use pulledbits\View\Directory;
use rikmeijer\Teach\Beans\Contactmoment;
use rikmeijer\Teach\Beans\Rating;
use rikmeijer\Teach\Beans\Ratingwaarde;
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
        if ($contactmoment->getId() === null) {
            return \pulledbits\Router\ErrorFactory::makeInstance('404');
        }

        $rating = $contactmoment->findRatingByIP(($request->getServerParams())['REMOTE_ADDR']);
        switch ($request->getMethod()) {
            case 'GET':
                return $this->handleGet($rating, $request->getQueryParams());

            case 'POST':
                return $this->handlePost($rating, $request->getParsedBody());
            default:
                return \pulledbits\Router\ErrorFactory::makeInstance('405');
        }
    }

    private function handleGet(Rating $ipRating, array $query): \pulledbits\Router\RouteEndPoint
    {
        if (array_key_exists('rating', $query)) {
            $rating = $query['rating'];
        } else {
            $rating = $ipRating->getWaarde()->getNaam();
        }

        return new \rikmeijer\Teach\PHPviewEndPoint(
            $this->phpviewDirectory->load(
                'feedback/supply',
                [
                    'rating' => $rating,
                    'explanation' => $ipRating->getInhoud()
                ]
            )
        );
    }

    private function handlePost(Rating $rating, array $parsedBody): \pulledbits\Router\RouteEndPoint
    {
        if ($this->gui->verifyCSRFToken($parsedBody['__csrf_value']) === false) {
            return ErrorFactory::makeInstance('403');
        }
        $rating->setWaarde(new Ratingwaarde($parsedBody['rating']));
        $rating->setInhoud($parsedBody['explanation']);
        $rating->save();

        return new \rikmeijer\Teach\PHPviewEndPoint($this->phpviewDirectory->load('feedback/processed'));
    }
}
