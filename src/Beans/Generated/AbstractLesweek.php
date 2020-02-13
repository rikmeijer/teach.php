<?php
declare(strict_types=1);

namespace rikmeijer\Teach\Beans\Generated;

use TheCodingMachine\TDBM\ResultIterator;
use TheCodingMachine\TDBM\AlterableResultIterator;
use Ramsey\Uuid\Uuid;
use rikmeijer\Teach\Beans\Les;
use TheCodingMachine\TDBM\AbstractTDBMObject;

/*
 * This file has been automatically generated by TDBM.
 * DO NOT edit this file, as it might be overwritten.
 * If you need to perform changes, edit the Lesweek class instead!
 */

/**
 * The AbstractLesweek class maps the 'lesweek' table in database.
 */
abstract class AbstractLesweek extends AbstractTDBMObject implements \JsonSerializable
{
    /**
     * The constructor takes all compulsory arguments.
     *
     * @param string $jaar
     * @param string $kalenderweek
     */
    public function __construct(string $jaar, string $kalenderweek)
    {
        parent::__construct();
        $this->setJaar($jaar);
        $this->setKalenderweek($kalenderweek);
    }

    /**
     * The getter for the "jaar" column.
     *
     * @return string
     */
    public function getJaar() : string
    {
        return $this->get('jaar', 'lesweek');
    }

    /**
     * The setter for the "jaar" column.
     *
     * @param string $jaar
     */
    public function setJaar(string $jaar) : void
    {
        $this->set('jaar', $jaar, 'lesweek');
    }

    /**
     * The getter for the "kalenderweek" column.
     *
     * @return string
     */
    public function getKalenderweek() : string
    {
        return $this->get('kalenderweek', 'lesweek');
    }

    /**
     * The setter for the "kalenderweek" column.
     *
     * @param string $kalenderweek
     */
    public function setKalenderweek(string $kalenderweek) : void
    {
        $this->set('kalenderweek', $kalenderweek, 'lesweek');
    }

    /**
     * The getter for the "onderwijsweek" column.
     *
     * @return string|null
     */
    public function getOnderwijsweek() : ?string
    {
        return $this->get('onderwijsweek', 'lesweek');
    }

    /**
     * The setter for the "onderwijsweek" column.
     *
     * @param string|null $onderwijsweek
     */
    public function setOnderwijsweek(?string $onderwijsweek) : void
    {
        $this->set('onderwijsweek', $onderwijsweek, 'lesweek');
    }

    /**
     * The getter for the "blokweek" column.
     *
     * @return string|null
     */
    public function getBlokweek() : ?string
    {
        return $this->get('blokweek', 'lesweek');
    }

    /**
     * The setter for the "blokweek" column.
     *
     * @param string|null $blokweek
     */
    public function setBlokweek(?string $blokweek) : void
    {
        $this->set('blokweek', $blokweek, 'lesweek');
    }

    /**
     * Returns the list of Les pointing to this bean via the jaar, kalenderweek column.
     *
     * @return Les[]|AlterableResultIterator
     */
    public function getLes() : AlterableResultIterator
    {
        return $this->retrieveManyToOneRelationshipsStorage('les', 'fk_leslesweek', 'les', ['les.jaar' => $this->get('jaar', 'lesweek'), 'les.kalenderweek' => $this->get('kalenderweek', 'lesweek')]);
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
        $array['jaar'] = $this->getJaar();
        $array['kalenderweek'] = $this->getKalenderweek();
        $array['onderwijsweek'] = $this->getOnderwijsweek();
        $array['blokweek'] = $this->getBlokweek();


        return $array;
    }

    /**
     * Returns an array of used tables by this bean (from parent to child relationship).
     *
     * @return string[]
     */
    protected function getUsedTables() : array
    {
        return [ 'lesweek' ];
    }
}