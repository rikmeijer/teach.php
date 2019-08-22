<?php

namespace rikmeijer\Teach;

use Aura\Session\Session;
use Auth0\SDK\Auth0;
use Doctrine\DBAL\Connection;
use pulledbits\Bootstrap\Bootstrap;
use rikmeijer\Teach\Beans\Useremailaddress;

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
     * @var callable
     */
    private $daoFactory;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->daoFactory = $bootstrap->resource('dao');
        $this->auth0 = $bootstrap->resource('auth0');
    }

    public function details(): \rikmeijer\Teach\Beans\User
    {
        $details = $this->auth0->getUser();
        if ($details === null) {
            header('Location: /sso/login', true, 302);
            exit;
        }

        /**
         * @var $useremailaddress Useremailaddress
         */
        $useremailaddress = ($this->daoFactory)('Useremailaddress')->getById($details['email']);
        return $useremailaddress->getUserid();
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

    public function importEventsFromCalendar(Calendar $calendar): int
    {
        return $calendar->importEventsForUser($this->details()->getId());
    }
}
