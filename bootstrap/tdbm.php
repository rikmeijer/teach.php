<?php

use TheCodingMachine\TDBM\Utils\DefaultNamingStrategy;

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {
    $naming = new TheCodingMachine\TDBM\Utils\DefaultNamingStrategy();
    $naming->setExceptions([
        'les' => 'Les'
    ]);

// The bean and DAO namespace that will be used to generate the beans and DAOs. These namespaces must be autoloadable from Composer.
    $beanNamespace = 'rikmeijer\\Teach\\Beans';
    $daoNamespace = 'rikmeijer\\Teach\\Daos';

    $service = new \TheCodingMachine\TDBM\TDBMService(
        new TheCodingMachine\TDBM\Configuration(
            $beanNamespace,
            $daoNamespace,
            $bootstrap->resource('dbal'),
            $naming,
            $bootstrap->resource('cache'),
            null,    // An optional SchemaAnalyzer instance
            $bootstrap->resource('logger'), // An optional logger
            []       // A list of generator listeners to hook into code generation
        )
    );

    // $service->setLogLevel(Psr\Log\LogLevel::DEBUG);

    return $service;
};
