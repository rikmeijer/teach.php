<?php


namespace rikmeijer\Teach\Beans\User;


use rikmeijer\Teach\Beans\User;
use rikmeijer\Teach\Beans\Useremailaddress;

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

}
