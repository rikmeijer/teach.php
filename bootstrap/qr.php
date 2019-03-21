<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap): void {
    $bootstrap->resource('phpview')->registerHelper(
        'qr',
        function (\pulledbits\View\TemplateInstance $templateInstance, int $size, string $data) : void {
            $renderer = new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle($size),
                new \BaconQrCode\Renderer\Image\ImagickImageBackEnd()
            );
            $writer = new \BaconQrCode\Writer($renderer);
            print $writer->writeString($data);
        }
    );
};
