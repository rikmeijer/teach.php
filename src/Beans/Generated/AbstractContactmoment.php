<?php
declare(strict_types=1);

namespace rikmeijer\Teach\Beans\Generated;

use TheCodingMachine\TDBM\ResultIterator;
use TheCodingMachine\TDBM\AlterableResultIterator;
use Ramsey\Uuid\Uuid;
use rikmeijer\Teach\Beans\Les;
use rikmeijer\Teach\Beans\User;
use rikmeijer\Teach\Beans\Rating;
use TheCodingMachine\TDBM\AbstractTDBMObject;

/*
 * This file has been automatically generated by TDBM.
 * DO NOT edit this file, as it might be overwritten.
 * If you need to perform changes, edit the Contactmoment class instead!
 */

/**
 * The AbstractContactmoment class maps the 'contactmoment' table in database.
 */
abstract class AbstractContactmoment extends AbstractTDBMObject implements \JsonSerializable
{
    /**
     * The constructor takes all compulsory arguments.
     *
     * @param Les $les
     * @param User $owner
     * @param \DateTimeImmutable $starttijd
     * @param \DateTimeImmutable $eindtijd
     * @param string $icalUid
     */
    public function __construct(Les $les, User $owner, \DateTimeImmutable $starttijd, \DateTimeImmutable $eindtijd, string $icalUid)
    {
        parent::__construct();
        $this->setLes($les);
        $this->setOwner($owner);
        $this->setStarttijd($starttijd);
        $this->setEindtijd($eindtijd);
        $this->setIcalUid($icalUid);
    }

    /**
     * The getter for the "id" column.
     *
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->get('id', 'contactmoment');
    }

    /**
     * The setter for the "id" column.
     *
     * @param int $id
     */
    public function setId(int $id) : void
    {
        $this->set('id', $id, 'contactmoment');
    }

    /**
     * Returns the Les object bound to this object via the les_id column.
     *
     * @return Les
     */
    public function getLes(): Les
    {
        return $this->getRef('fk_contactmoment_les', 'contactmoment');
    }

    /**
     * The setter for the Les object bound to this object via the les_id column.
     *
     * @param Les $object
     */
    public function setLes(Les $object) : void
    {
        $this->setRef('fk_contactmoment_les', $object, 'contactmoment');
    }

    /**
     * Returns the User object bound to this object via the owner column.
     *
     * @return User
     */
    public function getOwner(): User
    {
        return $this->getRef('FK_929E7431CF60E67C', 'contactmoment');
    }

    /**
     * The setter for the User object bound to this object via the owner column.
     *
     * @param User $object
     */
    public function setOwner(User $object) : void
    {
        $this->setRef('FK_929E7431CF60E67C', $object, 'contactmoment');
    }

    /**
     * The getter for the "starttijd" column.
     *
     * @return \DateTimeImmutable
     */
    public function getStarttijd() : \DateTimeImmutable
    {
        return $this->get('starttijd', 'contactmoment');
    }

    /**
     * The setter for the "starttijd" column.
     *
     * @param \DateTimeImmutable $starttijd
     */
    public function setStarttijd(\DateTimeImmutable $starttijd) : void
    {
        $this->set('starttijd', $starttijd, 'contactmoment');
    }

    /**
     * The getter for the "eindtijd" column.
     *
     * @return \DateTimeImmutable
     */
    public function getEindtijd() : \DateTimeImmutable
    {
        return $this->get('eindtijd', 'contactmoment');
    }

    /**
     * The setter for the "eindtijd" column.
     *
     * @param \DateTimeImmutable $eindtijd
     */
    public function setEindtijd(\DateTimeImmutable $eindtijd) : void
    {
        $this->set('eindtijd', $eindtijd, 'contactmoment');
    }

    /**
     * The getter for the "ruimte" column.
     *
     * @return string|null
     */
    public function getRuimte() : ?string
    {
        return $this->get('ruimte', 'contactmoment');
    }

    /**
     * The setter for the "ruimte" column.
     *
     * @param string|null $ruimte
     */
    public function setRuimte(?string $ruimte) : void
    {
        $this->set('ruimte', $ruimte, 'contactmoment');
    }

    /**
     * The getter for the "ical_uid" column.
     *
     * @return string
     */
    public function getIcalUid() : string
    {
        return $this->get('ical_uid', 'contactmoment');
    }

    /**
     * The setter for the "ical_uid" column.
     *
     * @param string $ical_uid
     */
    public function setIcalUid(string $ical_uid) : void
    {
        $this->set('ical_uid', $ical_uid, 'contactmoment');
    }

    /**
     * The getter for the "created_at" column.
     *
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt() : ?\DateTimeImmutable
    {
        return $this->get('created_at', 'contactmoment');
    }

    /**
     * The setter for the "created_at" column.
     *
     * @param \DateTimeImmutable|null $created_at
     */
    public function setCreatedAt(?\DateTimeImmutable $created_at) : void
    {
        $this->set('created_at', $created_at, 'contactmoment');
    }

    /**
     * The getter for the "updated_at" column.
     *
     * @return \DateTimeImmutable|null
     */
    public function getUpdatedAt() : ?\DateTimeImmutable
    {
        return $this->get('updated_at', 'contactmoment');
    }

    /**
     * The setter for the "updated_at" column.
     *
     * @param \DateTimeImmutable|null $updated_at
     */
    public function setUpdatedAt(?\DateTimeImmutable $updated_at) : void
    {
        $this->set('updated_at', $updated_at, 'contactmoment');
    }

    /**
     * Returns the list of Rating pointing to this bean via the contactmoment_id column.
     *
     * @return Rating[]|AlterableResultIterator
     */
    public function getRating() : AlterableResultIterator
    {
        return $this->retrieveManyToOneRelationshipsStorage('rating', 'fk_rating_contactmoment', 'rating', ['rating.contactmoment_id' => $this->get('id', 'contactmoment')]);
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
        $array['id'] = $this->getId();
        if (!$stopRecursion) {
            $object = $this->getLes();
            $array['les'] = $object ? $object->jsonSerialize(true) : null;
        }
        if (!$stopRecursion) {
            $object = $this->getOwner();
            $array['owner'] = $object ? $object->jsonSerialize(true) : null;
        }
        $array['starttijd'] = $this->getStarttijd()->format('c');
        $array['eindtijd'] = $this->getEindtijd()->format('c');
        $array['ruimte'] = $this->getRuimte();
        $array['icalUid'] = $this->getIcalUid();
        $array['createdAt'] = ($this->getCreatedAt() === null) ? null : $this->getCreatedAt()->format('c');
        $array['updatedAt'] = ($this->getUpdatedAt() === null) ? null : $this->getUpdatedAt()->format('c');


        return $array;
    }

    /**
     * Returns an array of used tables by this bean (from parent to child relationship).
     *
     * @return string[]
     */
    protected function getUsedTables() : array
    {
        return [ 'contactmoment' ];
    }

    /**
     * Method called when the bean is removed from database.
     *
     */
    protected function onDelete() : void
    {
        parent::onDelete();
        $this->setRef('fk_contactmoment_les', null, 'contactmoment');
        $this->setRef('FK_929E7431CF60E67C', null, 'contactmoment');
    }
}