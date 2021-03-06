<?php
/*
 * This file has been automatically generated by TDBM.
 * You can edit this file as it will not be overwritten.
 */

declare(strict_types=1);

namespace rikmeijer\Teach\Beans;

use rikmeijer\Teach\Avans\Rooster;
use rikmeijer\Teach\Beans\Generated\AbstractUser;
use rikmeijer\Teach\Daos\ContactmomentDao;
use TheCodingMachine\TDBM\ResultIterator;

/**
 * The User class maps the 'users' table in database.
 */
class User extends AbstractUser
{
    public function importEventsFromRooster(Rooster $rooster): int
    {
        return $rooster->importEventsForUser($this->getId());
    }

    public function getContactmomentenToday(): ResultIterator
    {
        return (new ContactmomentDao($this->tdbmService))->findContactmomentenTodayForUser($this->getId());
    }

    public function getContactmomentenByModule(Module $module): ResultIterator
    {
        return (new ContactmomentDao($this->tdbmService))->findContactmomentenForUserByModule(
            $this->getId(),
            $module
        );
    }
}
