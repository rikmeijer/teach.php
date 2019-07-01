<?php

namespace rikmeijer\Teach;

use Aura\Session\Session;
use Auth0\SDK\Auth0;
use pulledbits\Bootstrap\Bootstrap;
use TheCodingMachine\TDBM\TDBMService;

final class User
{
    /**
     * @var Session
     */
    private $session;

    private $oauth;

    /**
     * @var Auth0
     */
    private $auth0;

    /**
     * @var Calendar
     */
    private $calendar;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->calendar = $bootstrap->resource('calendar');
        $this->auth0 = $bootstrap->resource('auth0');
    }

    public function details(): array
    {
        $details = $this->auth0->getUser();
        if ($details === null) {
            header('Location: /sso/login', true, 302);
            exit;
        }
        return $details;
    }

    public function login() : void {
        $this->auth0->login();
    }


    public function authorize() : void {
        $details = $this->auth0->getUser();
        if ($details === null) {

        }
    }

    public function logout(): string
    {
        $this->auth0->logout();
        $return_to = 'https://' . $_SERVER['HTTP_HOST'];
        $logout_url = sprintf('https://%s/v2/logout?client_id=%s&returnTo=%s', 'pulledbits.eu.auth0.com', '2ohAli435Sq92PV14zh9vsXkFqofZrbh', $return_to);
        return $logout_url;
    }

    public function __get($name)
    {
        return $this->details()->$name;
    }

    public function __set($name, $value)
    {
        trigger_error('Can not write SSO', E_USER_ERROR);
    }
    public function __isset($name)
    {
        $details = $this->details();
        return isset($details->$name);
    }


    public function importCalendarEvents(): int
    {
        if ($this->details()->extra['employee'] === false) {
            return 0;
        }

        $userId = $this->details()->uid;
        return $this->calendar->importICal($userId, 'http://rooster.avans.nl/gcal/D' . $userId);
    }
}
