<?php

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {
    return function (string $entityIdentifier)  use ($bootstrap) {
        $class = 'rikmeijer\\Teach\\Daos\\' . $entityIdentifier . 'Dao';
        return new $class($bootstrap->resource('tdbm'));
    };
};
