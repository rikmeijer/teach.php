<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : \Aura\Session\CsrfToken {
    $session_factory = new \Aura\Session\SessionFactory;
    return $session_factory->newInstance($_COOKIE)->getCsrfToken();
};
