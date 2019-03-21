<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap): void {
    $bootstrap->resource('phpview')->registerHelper(
        'qr',
        function (\pulledbits\View\TemplateInstance $templateInstance, int $width, int $height, string $data) : void {
            $renderer = new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle($width),
                new \BaconQrCode\Renderer\Image\ImagickImageBackEnd()
            );
            $writer = new \BaconQrCode\Writer($renderer);
            print $writer->writeString($data);
        }
    );
};
