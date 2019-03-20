<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {
    return new \Avans\OAuth\Web($bootstrap->config('OAUTH'));
};
