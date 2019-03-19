<?php return function (\rikmeijer\Teach\Bootstrap $bootstrap) {
    return new \rikmeijer\Teach\SSO($bootstrap->resource('oauth'), $bootstrap->resource('session'));
};
