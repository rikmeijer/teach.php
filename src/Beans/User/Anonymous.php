<?php


namespace rikmeijer\Teach\Beans\User;


use rikmeijer\Teach\Avans\Rooster;
use rikmeijer\Teach\Beans\Module;
use rikmeijer\Teach\Beans\User;
use rikmeijer\Teach\Beans\Useremailaddress;
use rikmeijer\Teach\Daos\ContactmomentDao;
use TheCodingMachine\TDBM\ResultIterator;

class Anonymous extends User
{

    public function __construct()
    {
        parent::__construct('anonymous', new Useremailaddress('ano@nymo.us', $this), 'Anonymous');
    }

    private function login() {
        header('Location: /sso/login', true, 302);
        exit;
    }

    public function getId(): string
    {
        $this->login();
    }

    public function getEmail(): Useremailaddress
    {
        $this->login();
    }

    public function getName(): string
    {
        $this->login();
    }

    public function importEventsFromRooster(Rooster $rooster): int
    {
        return 0;
    }

    public function getContactmomentenToday(): ResultIterator
    {
        $this->login();
    }

    public function getContactmomentenByModule(Module $module): ResultIterator
    {
        $this->login();
    }
}
