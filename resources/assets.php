<?php return function(\rikmeijer\Teach\Bootstrap $bootstrap) : \League\Flysystem\FilesystemInterface {
    return new League\Flysystem\Filesystem(new League\Flysystem\Adapter\Local(__DIR__ . DIRECTORY_SEPARATOR . 'assets'));
};