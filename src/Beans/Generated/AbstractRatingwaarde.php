<?php
declare(strict_types=1);

namespace rikmeijer\Teach\Beans\Generated;

use TheCodingMachine\TDBM\ResultIterator;
use TheCodingMachine\TDBM\AlterableResultIterator;
use Ramsey\Uuid\Uuid;
use rikmeijer\Teach\Beans\Rating;
use TheCodingMachine\TDBM\AbstractTDBMObject;

/*
 * This file has been automatically generated by TDBM.
 * DO NOT edit this file, as it might be overwritten.
 * If you need to perform changes, edit the Ratingwaarde class instead!
 */

/**
 * The AbstractRatingwaarde class maps the 'ratingwaarde' table in database.
 */
abstract class AbstractRatingwaarde extends AbstractTDBMObject implements \JsonSerializable
{
    /**
     * The constructor takes all compulsory arguments.
     *
     * @param string $naam
     */
    public function __construct(string $naam)
    {
        parent::__construct();
        $this->setNaam($naam);
    }

    /**
     * The getter for the "naam" column.
     *
     * @return string
     */
    public function getNaam() : string
    {
        return $this->get('naam', 'ratingwaarde');
    }

    /**
     * The setter for the "naam" column.
     *
     * @param string $naam
     */
    public function setNaam(string $naam) : void
    {
        $this->set('naam', $naam, 'ratingwaarde');
    }

    /**
     * Returns the list of Rating pointing to this bean via the waarde column.
     *
     * @return Rating[]|AlterableResultIterator
     */
    public function getRating() : AlterableResultIterator
    {
        return $this->retrieveManyToOneRelationshipsStorage('rating', 'fk_rating_waarde', 'rating', ['rating.waarde' => $this->get('naam', 'ratingwaarde')]);
    }


    /**
     * Serializes the object for JSON encoding.
     *
     * @param bool $stopRecursion Parameter used internally by TDBM to stop embedded objects from embedding other objects.
     * @return array
     */
    public function jsonSerialize($stopRecursion = false)
    {
        $array = [];
        $array['naam'] = $this->getNaam();


        return $array;
    }

    /**
     * Returns an array of used tables by this bean (from parent to child relationship).
     *
     * @return string[]
     */
    protected function getUsedTables() : array
    {
        return [ 'ratingwaarde' ];
    }
}
