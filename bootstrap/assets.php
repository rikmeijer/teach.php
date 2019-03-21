<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap): \League\Flysystem\FilesystemInterface {
    $bootstrap->resource('phpview')->registerHelper('image', function(\pulledbits\View\TemplateInstance $templateInstance, string $imageIdentifier) : string {
        return $templateInstance->resource('assets')->read('img' . DIRECTORY_SEPARATOR . $imageIdentifier);
    });
    return new League\Flysystem\Filesystem(
        new League\Flysystem\Adapter\Local($bootstrap->config('ASSETS')['path'])
    );
};
