<?php return function(\rikmeijer\Teach\Bootstrap $bootstrap) {
    return new \Avans\OAuth\Web($bootstrap->config('OAUTH'));
};