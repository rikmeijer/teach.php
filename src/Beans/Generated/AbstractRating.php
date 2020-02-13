<?php
declare(strict_types=1);

namespace rikmeijer\Teach\Beans\Generated;

use TheCodingMachine\TDBM\ResultIterator;
use TheCodingMachine\TDBM\AlterableResultIterator;
use Ramsey\Uuid\Uuid;
use rikmeijer\Teach\Beans\Contactmoment;
use rikmeijer\Teach\Beans\Ratingwaarde;
use TheCodingMachine\TDBM\AbstractTDBMObject;

/*
 * This file has been automatically generated by TDBM.
 * DO NOT edit this file, as it might be overwritten.
 * If you need to perform changes, edit the Rating class instead!
 */

/**
 * The AbstractRating class maps the 'rating' table in database.
 */
abstract class AbstractRating extends AbstractTDBMObject implements \JsonSerializable
{
    /**
     * The constructor takes all compulsory arguments.
     *
     * @param string $ip
     * @param Contactmoment $contactmoment
     * @param Ratingwaarde $waarde
     */
    public function __construct(string $ip, Contactmoment $contactmoment, Ratingwaarde $waarde)
    {
        parent::__construct();
        $this->setIp($ip);
        $this->setContactmoment($contactmoment);
        $this->setWaarde($waarde);
    }

    /**
     * The getter for the "ip" column.
     *
     * @return string
     */
    public function getIp() : string
    {
        return $this->get('ip', 'rating');
    }

    /**
     * The setter for the "ip" column.
     *
     * @param string $ip
     */
    public function setIp(string $ip) : void
    {
        $this->set('ip', $ip, 'rating');
    }

    /**
     * Returns the Contactmoment object bound to this object via the contactmoment_id column.
     *
     * @return Contactmoment
     */
    public function getContactmoment(): Contactmoment
    {
        return $this->getRef('fk_rating_contactmoment', 'rating');
    }

    /**
     * The setter for the Contactmoment object bound to this object via the contactmoment_id column.
     *
     * @param Contactmoment $object
     */
    public function setContactmoment(Contactmoment $object) : void
    {
        $this->setRef('fk_rating_contactmoment', $object, 'rating');
    }

    /**
     * Returns the Ratingwaarde object bound to this object via the waarde column.
     *
     * @return Ratingwaarde
     */
    public function getWaarde(): Ratingwaarde
    {
        return $this->getRef('fk_rating_waarde', 'rating');
    }

    /**
     * The setter for the Ratingwaarde object bound to this object via the waarde column.
     *
     * @param Ratingwaarde $object
     */
    public function setWaarde(Ratingwaarde $object) : void
    {
        $this->setRef('fk_rating_waarde', $object, 'rating');
    }

    /**
     * The getter for the "inhoud" column.
     *
     * @return string|null
     */
    public function getInhoud() : ?string
    {
        return $this->get('inhoud', 'rating');
    }

    /**
     * The setter for the "inhoud" column.
     *
     * @param string|null $inhoud
     */
    public function setInhoud(?string $inhoud) : void
    {
        $this->set('inhoud', $inhoud, 'rating');
    }

    /**
     * The getter for the "created_at" column.
     *
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt() : ?\DateTimeImmutable
    {
        return $this->get('created_at', 'rating');
    }

    /**
     * The setter for the "created_at" column.
     *
     * @param \DateTimeImmutable|null $created_at
     */
    public function setCreatedAt(?\DateTimeImmutable $created_at) : void
    {
        $this->set('created_at', $created_at, 'rating');
    }

    /**
     * The getter for the "updated_at" column.
     *
     * @return \DateTimeImmutable|null
     */
    public function getUpdatedAt() : ?\DateTimeImmutable
    {
        return $this->get('updated_at', 'rating');
    }

    /**
     * The setter for the "updated_at" column.
     *
     * @param \DateTimeImmutable|null $updated_at
     */
    public function setUpdatedAt(?\DateTimeImmutable $updated_at) : void
    {
        $this->set('updated_at', $updated_at, 'rating');
    }

    /**
     * The getter for the "deleted_at" column.
     *
     * @return \DateTimeImmutable|null
     */
    public function getDeletedAt() : ?\DateTimeImmutable
    {
        return $this->get('deleted_at', 'rating');
    }

    /**
     * The setter for the "deleted_at" column.
     *
     * @param \DateTimeImmutable|null $deleted_at
     */
    public function setDeletedAt(?\DateTimeImmutable $deleted_at) : void
    {
        $this->set('deleted_at', $deleted_at, 'rating');
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
        $array['ip'] = $this->getIp();
        if (!$stopRecursion) {
            $object = $this->getContactmoment();
            $array['contactmoment'] = $object ? $object->jsonSerialize(true) : null;
        }
        if (!$stopRecursion) {
            $object = $this->getWaarde();
            $array['waarde'] = $object ? $object->jsonSerialize(true) : null;
        }
        $array['inhoud'] = $this->getInhoud();
        $array['createdAt'] = ($this->getCreatedAt() === null) ? null : $this->getCreatedAt()->format('c');
        $array['updatedAt'] = ($this->getUpdatedAt() === null) ? null : $this->getUpdatedAt()->format('c');
        $array['deletedAt'] = ($this->getDeletedAt() === null) ? null : $this->getDeletedAt()->format('c');


        return $array;
    }

    /**
     * Returns an array of used tables by this bean (from parent to child relationship).
     *
     * @return string[]
     */
    protected function getUsedTables() : array
    {
        return [ 'rating' ];
    }

    /**
     * Method called when the bean is removed from database.
     *
     */
    protected function onDelete() : void
    {
        parent::onDelete();
        $this->setRef('fk_rating_contactmoment', null, 'rating');
        $this->setRef('fk_rating_waarde', null, 'rating');
    }
}