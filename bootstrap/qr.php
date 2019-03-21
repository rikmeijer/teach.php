<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap): \BaconQrCode\Renderer\Image\AbstractRenderer {
    $bootstrap->resource('phpview')->registerHelper(
        'qr',
        function (\pulledbits\View\TemplateInstance $templateInstance, int $width, int $height, string $data): void {
            $renderer = new \BaconQrCode\Renderer\Image\Png();
            $renderer->setHeight($width);
            $renderer->setWidth($height);
            $writer = new \BaconQrCode\Writer($renderer);
            print $writer->writeString($data);
        }
    );
    return new \BaconQrCode\Renderer\Image\Png();
};
