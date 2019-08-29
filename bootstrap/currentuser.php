<?php use rikmeijer\Teach\Beans\User;
use rikmeijer\Teach\Beans\Useremailaddress;

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : User{
    $details = $bootstrap->resource('auth0')->getUser();
    if ($details === null) {
        return new User\Anonymous();
    }

    /**
     * @var $useremailaddress Useremailaddress
     */
    $useremailaddress = ($bootstrap->resource('dao')('Useremailaddress'))->getById($details['email']);
    return $useremailaddress->getUserid();
};
