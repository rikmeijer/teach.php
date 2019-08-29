<?php

namespace rikmeijer\Teach;

use pulledbits\Bootstrap\Bootstrap;
use rikmeijer\Teach\Avans\Rooster;
use rikmeijer\Teach\Beans\Module;
use rikmeijer\Teach\Daos\ContactmomentDao;
use TheCodingMachine\TDBM\ResultIterator;

final class User
{
    /**
     * @var \rikmeijer\Teach\Beans\User
     */
    private $currentUser;

    /**
     * @var ContactmomentDao
     */
    private $contactmomentDao;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->currentUser = $bootstrap->resource('currentuser');
        $this->contactmomentDao = $bootstrap->resource('dao')('Contactmoment');
    }

    public function importEventsFromRooster(Rooster $rooster): int
    {
        return $rooster->importEventsForUser($this->currentUser->getId());
    }

    public function findContactmomentenToday(): ResultIterator
    {
        return $this->contactmomentDao->findContactmomentenTodayForUser($this->currentUser->getId());
    }

    public function findContactmomentenByModule(Module $module): ResultIterator
    {
        return $this->contactmomentDao->findContactmomentenForUserByModule(
            $this->currentUser->getId(),
            $module
        );
    }
}
