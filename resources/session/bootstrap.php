<?php
$session_factory = new \Aura\Session\SessionFactory;
return $session_factory->newInstance($_COOKIE);
