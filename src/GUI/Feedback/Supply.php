<?php


namespace rikmeijer\Teach\GUI\Feedback;

use Psr\Http\Message\ServerRequestInterface;
use pulledbits\View\Directory;
use rikmeijer\Teach\Beans\Rating;
use rikmeijer\Teach\Beans\Ratingwaarde;
use rikmeijer\Teach\GUI\Feedback;
use rikmeijer\Teach\PHPviewEndPoint;

class Supply
{
    private $gui;
    private $phpviewDirectory;

    public function __construct(Feedback $gui, Directory $phpviewDirectory)
    {
        $this->gui = $gui;
        $this->phpviewDirectory = $phpviewDirectory;
    }

    public function handleRequest(ServerRequestInterface $request): PHPviewEndPoint
    {
        $contactmoment = $this->gui->retrieveContactmoment($request->getAttribute('contactmomentIdentifier'));
        if ($contactmoment->getId() === null) {
            return ErrorFactory::makeInstance('404');
        }

        $rating = $contactmoment->findRatingByIP(($request->getServerParams())['REMOTE_ADDR']);
        switch ($request->getMethod()) {
            case 'GET':
                return $this->handleGet($rating, $request->getQueryParams());

            case 'POST':
                return $this->handlePost($rating, $request->getParsedBody());
            default:
                return ErrorFactory::makeInstance('405');
        }
    }

    private function handleGet(Rating $ipRating, array $query): PHPviewEndPoint
    {
        if (array_key_exists('rating', $query)) {
            $rating = $query['rating'];
        } else {
            $rating = $ipRating->getWaarde()->getNaam();
        }

        return new PHPviewEndPoint(
            $this->phpviewDirectory->load(
                'feedback/supply',
                [
                    'rating' => $rating,
                    'explanation' => $ipRating->getInhoud()
                ]
            )
        );
    }

    private function handlePost(Rating $rating, array $parsedBody): PHPviewEndPoint
    {
        if ($this->gui->verifyCSRFToken($parsedBody['__csrf_value']) === false) {
            return ErrorFactory::makeInstance('403');
        }
        $rating->setWaarde(new Ratingwaarde($parsedBody['rating']));
        $rating->setInhoud($parsedBody['explanation']);
        $rating->save();

        return new PHPviewEndPoint($this->phpviewDirectory->load('feedback/processed'));
    }
}
