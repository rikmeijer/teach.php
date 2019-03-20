<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap): \League\Flysystem\FilesystemInterface {
    return new League\Flysystem\Filesystem(
        new League\Flysystem\Adapter\Local($bootstrap->config('ASSETS')['path'])
    );
};
