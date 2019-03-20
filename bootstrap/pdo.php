<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {
    $config = $bootstrap->config('DB');
    return new \PDO(
        $config['CONNECTION'] . ':host=' . $config['HOST'] . ';dbname=' . $config['DATABASE'],
        $config['USERNAME'],
        $config['PASSWORD'],
        array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
    );
};
