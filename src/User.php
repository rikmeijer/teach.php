<?php

namespace rikmeijer\Teach;

use Auth0\SDK\Auth0;
use pulledbits\Bootstrap\Bootstrap;
use rikmeijer\Teach\Avans\Rooster;
use rikmeijer\Teach\Beans\Module;
use rikmeijer\Teach\Beans\Useremailaddress;
use rikmeijer\Teach\Daos\ContactmomentDao;
use TheCodingMachine\TDBM\ResultIterator;

final class User
{
    /**
     * @var Auth0
     */
    private $auth0;

    /**
     * @var callable
     */
    private $daoFactory;

    /**
     * @var ContactmomentDao
     */
    private $contactmomentDao;

    public function __construct(Bootstrap $bootstrap)
    {
        $this->daoFactory = $bootstrap->resource('dao');
        $this->auth0 = $bootstrap->resource('auth0');
        $this->contactmomentDao = ($this->daoFactory)('Contactmoment');
    }

    public function profile() {
        $details = $this->auth0->getUser();
        if ($details === null) {
            header('Location: /sso/login', true, 302);
            exit;
        }
        return $details;
    }

    public function details(): \rikmeijer\Teach\Beans\User
    {
        $details = $this->profile();
        
        /**
         * @var $useremailaddress Useremailaddress
         */
        $useremailaddress = ($this->daoFactory)('Useremailaddress')->getById($details['email']);
        return $useremailaddress->getUserid();
    }

    public function login(): void
    {
        $this->auth0->login();
    }


    public function authorize(): void
    {
        $details = $this->auth0->getUser();
        if ($details === null) {

        }
    }

    public function logout(): string
    {
        $this->auth0->logout();
        $return_to = 'https://' . $_SERVER['HTTP_HOST'];
        $logout_url = sprintf(
            'https://%s/v2/logout?client_id=%s&returnTo=%s',
            'pulledbits.eu.auth0.com',
            '2ohAli435Sq92PV14zh9vsXkFqofZrbh',
            $return_to
        );
        return $logout_url;
    }

    public function importEventsFromRooster(Rooster $rooster): int
    {
        return $rooster->importEventsForUser($this->details()->getId());
    }

    public function findContactmomentenToday(): ResultIterator
    {
        return $this->contactmomentDao->findContactmomentenTodayForUser($this->details()->getId());
    }

    public function findContactmomentenByModule(Module $module): ResultIterator
    {
        return $this->contactmomentDao->findContactmomentenForUserByModule(
            $this->details()->getId(),
            $module
        );
    }
}
