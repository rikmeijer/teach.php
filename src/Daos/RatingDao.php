<?php
/*
 * This file has been automatically generated by TDBM.
 * You can edit this file as it will not be overwritten.
 */

declare(strict_types=1);

namespace rikmeijer\Teach\Daos;

use rikmeijer\Teach\Beans\Rating;
use rikmeijer\Teach\Beans\Ratingwaarde;
use rikmeijer\Teach\Daos\Generated\AbstractRatingDao;

/**
 * The RatingDao class will maintain the persistence of Rating class into the rating table.
 */
class RatingDao extends AbstractRatingDao
{
    public function getById(string $ipAddress, \rikmeijer\Teach\Beans\Contactmoment $contactmoment) : Rating
    {
        $rating = $this->findOne(["contactmoment_id" => $contactmoment->getId(), "ip" => $ipAddress]);
        if ($rating === null) {
            $rating = new Rating($ipAddress, $contactmoment, (new RatingwaardeDao($this->tdbmService))->getById('0'));
            $this->save($rating);
        }
        return $rating;
    }
}
