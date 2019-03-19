<?php return function (\rikmeijer\Teach\Bootstrap $bootstrap) {
    return new \rikmeijer\Teach\PHPViewDirectoryFactory($bootstrap->resource('session'));
};
