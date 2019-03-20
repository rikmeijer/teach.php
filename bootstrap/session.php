<?php return function (\rikmeijer\Teach\Bootstrap $bootstrap) {
    $session_factory = new \Aura\Session\SessionFactory;
    return $session_factory->newInstance($_COOKIE);
};
