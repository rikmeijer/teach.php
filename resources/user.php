<?php return function (\rikmeijer\Teach\Bootstrap $bootstrap): \rikmeijer\Teach\User {
    return new \rikmeijer\Teach\User(
        $bootstrap->resource('sso'),
        $bootstrap->resource('session'),
        $bootstrap->resource('database')
    );
};
