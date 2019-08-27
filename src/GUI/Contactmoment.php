<?php

namespace rikmeijer\Teach\GUI;

use rikmeijer\Teach\Calendar;
use rikmeijer\Teach\GUI;
use rikmeijer\Teach\User;

class Contactmoment implements GUI
{

    /**
     * @var Calendar
     */
    private $rooster;

    /**
     * @var User
     */
    private $user;
    private $phpviewDirectory;

    public function __construct(\pulledbits\Bootstrap\Bootstrap $bootstrap)
    {
        $this->rooster = $bootstrap->resource('rooster');
        $this->user = $bootstrap->resource('user');
        $this->phpviewDirectory = $bootstrap->resource('phpview');
    }

    public function importRooster(): int
    {
        return $this->user->importEventsFromRooster($this->rooster);
    }

    public function createRoutes() : array
    {
        return [
            '(GET|POST):/contactmoment/import' => new Contactmoment\Import($this, $this->phpviewDirectory)
        ];
    }
}
