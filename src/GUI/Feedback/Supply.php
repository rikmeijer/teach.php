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

    public function handleGet(Rating $ipRating, array $query): PHPviewEndPoint
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

    public function handlePost(Rating $rating, array $parsedBody): PHPviewEndPoint
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
