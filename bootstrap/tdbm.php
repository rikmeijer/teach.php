<?php

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {
    $config = $bootstrap->config('DB');

    $dbConnection = Doctrine\DBAL\DriverManager::getConnection([
                                                                   'user' => $config['USERNAME'],
                                                                   'password' => $config['PASSWORD'],
                                                                   'host' => $config['HOST'],
                                                                   'driver' => 'pdo_' . $config['CONNECTION'],
                                                                   'dbname' => $config['DATABASE'],
                                                               ], new \Doctrine\DBAL\Configuration());

// The bean and DAO namespace that will be used to generate the beans and DAOs. These namespaces must be autoloadable from Composer.
    $beanNamespace = 'rikmeijer\\Teach\\Beans';
    $daoNamespace = 'rikmeijer\\Teach\\Daos';

    return new \TheCodingMachine\TDBM\TDBMService(new TheCodingMachine\TDBM\Configuration(
                                       $beanNamespace,
                                       $daoNamespace,
                                       $dbConnection,
                                       new TheCodingMachine\TDBM\Utils\DefaultNamingStrategy(),
                                       $bootstrap->resource('cache'),
                                       null,    // An optional SchemaAnalyzer instance
                                       $bootstrap->resource('logger'), // An optional logger
                                       []       // A list of generator listeners to hook into code generation
                                   ));
};
