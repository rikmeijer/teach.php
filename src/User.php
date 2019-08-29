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
        return $this->currentUser->importEventsFromRooster($rooster);
    }

    public function findContactmomentenToday(): ResultIterator
    {
        return $this->currentUser->getContactmomentenToday();
    }

    public function findContactmomentenByModule(Module $module): ResultIterator
    {
        return $this->currentUser->getContactmomentenByModule($module);
    }
}
